<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Level;
use App\Models\Major;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = Setting::getAllSettings();

        $specializations = Major::query()->get(['name', 'id', 'num_levels'])->toArray();

        $levels = Level::query()->get(['name', 'id'])->toArray();

        $subjects = Course::query()->where('is_blocked', false)->get(['name', 'id', 'level_id', 'major_id', 'term'])->toArray();

        return view('dashboard.admin.settings', compact('settings', 'specializations', 'levels', 'subjects'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'language' => 'required|in:ar,en',
            'theme' => 'required|in:light,dark',
            'email_notifications' => 'required|in:on,off',
            'backup_frequency' => 'sometimes|required|in:daily,weekly,monthly,none',
            'block_subject_enabled' => 'nullable|boolean',
            'specialization' => 'nullable|string',
            'level' => 'nullable|integer',
            'subject' => 'nullable|string',
            'attendance_threshold' => 'required|integer|min:50|max:100',
            'late_threshold' => 'required|integer|min:1|max:30',
        ]);

//        $validated['block_subject_enabled'] = $request->has('block_subject_enabled');


       if($course = Course::query()->where('is_blocked', false)->find($validated['subject'])) {
           $course->update(['is_blocked' => true]);
       }

        $validated['block_subject_enabled'] = false;
        $validated['specialization'] = null;
        $validated['level'] = null;
        $validated['subject'] = null;

        Setting::updateSettings($validated);

        return redirect()->route('settings.index')
            ->with('message', ucwords(__('main.settings_updated_successfully')));
    }

    public function reset()
    {
        Setting::resetToDefault();
        return response()->json(['success' => true]);
    }
}
