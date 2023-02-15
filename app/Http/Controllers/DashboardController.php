<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index() {

        // show auth user notifications
        $user = auth()->user();
        $notifications = $user->notifications()->latest()->paginate();
        return view('dashboard', compact('notifications'));

    }

    public function update($id) {
        
    }
}
