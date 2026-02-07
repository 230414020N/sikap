<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = auth()->user()->notifications()->latest()->paginate(10);

        return view('pelamar.notifications.index', compact('notifications'));
    }

    public function markAsRead($id)
    {
        $notif = auth()->user()->notifications()->findOrFail($id);
        $notif->markAsRead();

        return back();
    }
}
