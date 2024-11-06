<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\StudentAnnouncement;
use App\Models\User;
use Illuminate\Http\Request;

class TeacherAnnouncementController extends Controller
{

    public function index() {
        $announcements = Announcement::orderBy('id', 'desc')->simplePaginate(10);
        return view('announcement.index',[
            'announcements' => $announcements
        ]);
    }
    public function createView() {
        return view('announcement.add');
    }
    public function saveAnnouncement(Request $request)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'desc' => ['required', 'string'],
        ]);

        $announcement = Announcement::create([
            'title' => $request->title,
            'content' => $request->desc
        ]);

        $teachers = User::where('role', User::ROLE_TEACHER)->get();
        foreach ($teachers as $teacher) {
            $teacher->announcements()->attach($announcement->id, ['is_read' => false]);
        }
        return redirect()->route('teacher.announcement.list')->with('success', 'Announcement successfully');
    }

    public function markAsRead($id)
    {
        $user = auth()->user();
        $user->announcements()->updateExistingPivot($id, ['is_read' => true]);
        return redirect()->route('dashboard');
    }

    public function viewTeacherAnnouncement($id, Request $request) {
        $announcements = StudentAnnouncement::where('teacher_id', $id)->orderBy('id', 'desc')->simplePaginate(10);
        return view('student-announcement.index',[
            'announcements' => $announcements,
            'user' => $request->user(),
        ]);
    }
}
