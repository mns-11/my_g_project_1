<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Auth::user()->notifications()->latest()->paginate(20);

        return response()->json($notifications);
    }

    public function update()
    {
        $is_updated = auth()->user()->unreadNotifications()->update(['read_at' => now()]);
        return response()->json($is_updated,204);

    }

    public function delete()
    {
        $is_deleted = auth()->user()->notifications()->delete();
        return response()->json($is_deleted,204);
    }
}
