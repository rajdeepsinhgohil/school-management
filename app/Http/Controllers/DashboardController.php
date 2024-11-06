<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard(Request $request) {
        $user = $request->user();
        $unreadAnnouncements = $user->announcements()->wherePivot('is_read', false)->get();

        return view('dashboard', [
            'unreadAnnouncements' => $unreadAnnouncements
        ]);
    }
}
