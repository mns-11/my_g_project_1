<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Http\Requests\Auth\SendPasswordResetRequest;
use App\Http\Requests\Auth\UpdatePasswordRequest;
use App\Http\Requests\Auth\VerifyOtpPasswordResetRequest;
use App\Models\Level;
use App\Models\Major;
use App\Models\PasswordResetOtp;
use App\Models\User;
use App\Notifications\SendResetPasswordOTPNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{

    /**
     * Student Login.
     *
     * Authenticates a student using their email and password credentials.
     * If successful, returns a bearer token for API authentication.
     *
     * ### Request Requirements:
     * - `email`: string, required.
     * - `password`: string, required.
     *
     * ### JSON Response Structure:
     * **Success:**
     * - `status`: `true`
     * - `token`: string (access token)
     * - `data`: user resource
     *
     * **Failure:**
     * - `status`: `false`
     * - `error`: Localized error message
     *
     * @param LoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request)
    {
        $request->validated();
        if($user = User::query()->role('student')->where('email',$request->email)->first() and $user->hasRole('student')) {
            if (Hash::check($request->password, $user->password)) {
                $token = $user->createToken('access-token')->plainTextToken;
                return response()->json([
                    'status' => true,
                    'token' => $token,
                    'data' => $user->toResource()
                ]);
            }
        }
        return response()->json(['status' => false, 'error' => ucwords(__('main.email_or_password_is_incorrect_please_try_again'))], 401);
    }


    /**
     * Student Registration.
     *
     * Registers a new student account and returns an access token upon success.
     * The student is automatically assigned the `student` role and linked to a major and college.
     *
     * ### Request Requirements:
     * - `name`: string, required
     * - `email`: string, required, unique
     * - `password`: string, required, confirmed
     * - `major_id`: int, required
     *
     * ### JSON Response Structure:
     * **Success:**
     * - `status`: `true`
     * - `token`: string (access token)
     * - `data`: user resource
     *
     * **Failure:**
     * - `status`: `false`
     * - `error`: Localized error message
     *
     * @param RegisterRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(RegisterRequest $request)
    {
        $data =  $request->validated();

        $levelId = Level::query()->first()->id;
        $major = Major::query()->findOrFail($data['major_id']);

        //        $data['enrollment_number'] = $this->generateEnrollmentNumber($data['major_id']);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'major_id' => $major->id,
            'college_id' => $major->college_id,
            'level_id' => $levelId,
            'address' => $data['address'],
            'phone' => $data['phone'],
            'birthdate' => $data['birthdate'],
            'gender' => $data['gender'],
            'password' => bcrypt($data['password']),
        ]);
        if($user) {
            $user->assignRole('student');
            $token = $user->createToken('access-token')->plainTextToken;
            return response()->json([
                'status' => true,
                'token' => $token,
                'data' => $user->toResource()
            ]);
        }
        return response()->json(['status' => false, 'error' => ucwords(__('main.email_or_password_is_incorrect_please_try_again'))], 401);
    }

    /**
     * Get Authenticated User Info.
     *
     * Returns the currently authenticated user's data.
     *
     * ### JSON Response Structure:
     * - `status`: boolean
     * - `data`: user resource
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function user()
    {

        return response()->json([
            'status' => true,
            'data' => auth()->user()->toResource()
        ]);
    }

    public function updatePassword(UpdatePasswordRequest $request)
    {
        $validatedData = $request->validated();

        $user = User::query()->find(auth()->id());

        $user->forceFill([
            'password' => Hash::make($validatedData['password'])
        ])->setRememberToken(Str::random(60));

        $is_updated =  $user->save();

        return response()->json([
            'message' => $is_updated ? ucwords(__('main.successfully_saved')) : ucwords(__('main.save_failed')),
        ], $is_updated ? 200 : 404);

    }
    public function logout()
    {
        request()->user()->currentAccessToken()->delete();
        request()->user()->refreshTokens()->where('is_revoked', false)->update(['is_revoked' => true]);
        return response()->json(['message' => __('main.logged_out')]);
    }
    public function sendForgotPasswordOtp(SendPasswordResetRequest $request)
    {
        $validatedData = $request->validated();
        $email = $validatedData['email'];
        $is_sent = false;
        $otp = rand(1000, 9999);
        $expireIn = 30;
        $expiresAt = now()->addMinutes($expireIn);
        $is_exists = $this->isOtpActiveAndExists($email);
        if (!$is_exists) {
            PasswordResetOtp::updateOrCreate(
                ['email' => $email],
                ['otp' => $otp, 'expires_at' => $expiresAt]
            );

            $user = User::query()->where('email', $email)->firstOrFail();

            $user->notify(new SendResetPasswordOTPNotification($otp, $expireIn));

            $is_sent = true;
        }

        return response()->json([
            'message' => $is_sent ? ucwords(__('main.otp_sent_successfully_check_the_email')) : ucwords(__('main.otp_not_send_try_later')),
        ], $is_sent ? 200 : 400);
    }

    public function verifyOtp(VerifyOtpPasswordResetRequest $request)
    {
        $validatedData = $request->validated();
        $email = $validatedData['email'];
        $otp = $validatedData['otp'];

        $is_verified = false;
        $userOtpRecord = PasswordResetOtp::where('email', $email)->where('otp', $otp)->first();
        if (!empty($userOtpRecord) && now()->lt($userOtpRecord->expires_at)) {
            $is_verified = true;
        }

        return response()->json([
            'message' => $is_verified ? ucwords(__('main.otp_verified_successfully')) : ucwords(__('main.otp_failed_to_verify')),
        ], $is_verified ? 200 : 400);
    }

    public function resetPassword(ResetPasswordRequest $request)
    {
        $validatedData = $request->validated();
        $email = $validatedData['email'];
        $otp = $validatedData['otp'];
        $password = $validatedData['password'];

        $user = User::query()->where('email', $email)->firstOrFail();
        $userOtpRecord = PasswordResetOtp::where('email', $user->email)->where('otp', $otp)->firstOrFail();

        $is_updated = false;

        if (!now()->gt($userOtpRecord->expires_at)) {
            $user->forceFill([
                'password' => Hash::make($password)
            ])->setRememberToken(Str::random(60));

            $user->save();

            $userOtpRecord->delete();
            $is_updated = true;
        }


        return response()->json([
            'message' => $is_updated ? ucwords(__('main.password_updated_successfully')) : ucwords(__('main.otp_has_expired')),
        ], $is_updated ? 200 : 404);
    }

    private function generateEnrollmentNumber(int $majorId): string
    {
        $prefix = substr((string)$majorId, -1);
        $maxAttempts = 100;
        $attempts = 0;

        do {
            $randomPart = str_pad(mt_rand(0, 9999999), 7, '0', STR_PAD_LEFT);
            $enrollmentNumber = $prefix . $randomPart;

            $exists = User::query()->role('student')->where('enrollment_number', $enrollmentNumber)->exists();

            if (++$attempts >= $maxAttempts) {
                throw new \RuntimeException('Failed to generate unique enrollment number');
            }
        } while ($exists);

        return $enrollmentNumber;
    }

    /**
     * Check for existing active OTP
     *
     * @param string $email User email
     * @return bool True if valid OTP exists
     */
    private function isOtpActiveAndExists(string $email)
    {
        return PasswordResetOtp::query()->where('email', $email)->where('expires_at', '>', now())->exists();
    }
}
