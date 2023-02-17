<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Notifications\Notification;

class DashboardController extends Controller
{
    public function index() {

        // show auth user notifications
        $notifications = auth()->user()->unreadNotifications()->latest()->paginate();
        return view('dashboard', compact('notifications'));

    }

    public function update($id) {
        
        $notification = auth()->user()->unreadNotifications()->where('id', $id)->first();

        if($notification) {
            $notification->markAsRead();
            return redirect('dashboard');        }

    }
}
