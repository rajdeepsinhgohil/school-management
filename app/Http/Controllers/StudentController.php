<?php

namespace App\Http\Controllers;

use App\Mail\StudentAnnouncment;
use App\Models\Announcement;
use App\Models\Student;
use App\Models\StudentAnnouncement;
use App\Models\StudentParent;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Validation\Rule;

class StudentController extends Controller
{
    public function index(Request $request) {
        $user = $request->user();

        $students = Student::with(['teacher' => function(BelongsTo $belongsTo) {
            $belongsTo->select(['id','name']);
        }]);
        if ($user->role == User::ROLE_TEACHER) {
            $students = $students->where('teacher_id', $user->id);
        }
        $students = $students->orderBy('id','desc')->simplePaginate();
        return view('student.index', [
            'students' => $students,
            'user' => $user
        ]);
    }

    public function createView(Request $request) {
        $user = $request->user();
        $teachers = [];

        if ($user->role == User::ROLE_ADMIN) {
            $teachers = User::select(['id', 'name'])->where('role', User::ROLE_TEACHER)->get();
        }

        $parents = StudentParent::select(['id', 'name'])->get();
        return view('student.add', [
            'user' => $user,
            'teachers' => $teachers,
            'parents' => $parents
        ]);
    }

    /**
     * create a teacher
     */
    public function saveStudent(Request $request) {
        $user = $request->user();
        $teacher = $user->id;
        $validate = [
            'name' => ['required', 'string', 'max:40'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.Student::class],
            'standard' => ['required','numeric'],
            'parent' => ['required']
        ];
        if ($user->role == User::ROLE_ADMIN) {
            $validate['teacher'] = ['required','numeric'];
            $teacher = $request->teacher;
        }
        $request->validate($validate);

        Log::info($request->all());
        Student::create([
            'name' => $request->name,
            'email' => $request->email,
            'standard' => $request->standard,
            'teacher_id' => $teacher,
            'parent_id' => $request->parent,
        ]);

        return redirect(route('student.list'))->with('success', 'Create successfully');
    }

    public function editView($id, Request $request) {
        $student = Student::where('id', $id)->first();
        if ($student) {
            $user = $request->user();
            $teachers = [];

            if ($user->role == User::ROLE_ADMIN) {
                $teachers = User::select(['id', 'name'])->where('role', User::ROLE_TEACHER)->get();
            }
            $parents = StudentParent::select(['id', 'name'])->get();
            return view('student.edit', [
                'student' => $student,
                'teachers' => $teachers,
                'user' => $user,
                'parents' => $parents
            ]);
        }
        return back()->with('error', 'student not found');
    }

    /**
     * @param Request $request
     * update a teacher
     */
    public function editStudent(Request $request) {
        $user = $request->user();
        $teacher = $user->id;
        $validate = [
            'id' => ['required', Rule::exists('students', 'id')],
            'name' => ['required', 'string', 'max:40'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('students', 'email')->whereNot('id', $request->id)],
            'standard' => ['required','numeric'],
            'parent' => ['required']
        ];
        if ($user->role == User::ROLE_ADMIN) {
            $validate['teacher'] = ['required','numeric'];
            $teacher = $request->teacher;
        }
        $request->validate($validate);

        Student::where('id', $request->id)->update([
            'name' => $request->name,
            'email' => $request->email,
            'standard' => $request->standard,
            'teacher_id' => $teacher,
            'parent_id' => $request->parent,
        ]);

        return redirect()->route('student.list')->with('success', 'Edit successfully');
    }

    /**
     * @param $id
     * @param Request $request
     * delete requested teacher
     */
    public function delete($id, Request $request) {
        validator($request->route()->parameters(), [
            'id' => ['required', Rule::exists('students', 'id')],
        ])->validate();

        Student::where('id', $request->id)->delete();
        return redirect(route('student.list'))->with('success', 'Delete successfully');
    }

    public function announcementList(Request $request) {
        $announcements = StudentAnnouncement::orderBy('id', 'desc')->simplePaginate(10);
        return view('student-announcement.index',[
            'announcements' => $announcements,
            'user' => $request->user(),
        ]);
    }
    public function announcementAdd() {
        return view('student-announcement.add');
    }
    public function saveAnnouncement(Request $request)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'desc' => ['required', 'string'],
        ]);

        $user = $request->user();

        $announcement = StudentAnnouncement::create([
            'title' => $request->title,
            'content' => $request->desc,
            'teacher_id' => $user->id
        ]);

        $students = Student::with(['parent'])->where('teacher_id', $user->id)->get();
        if (count($students) > 0) {
            foreach ($students as $student) {
                Mail::to([$student->email, $student->parent->email])->send(new StudentAnnouncment($announcement));
            }
        }
        return redirect()->route('student.announcement.list')->with('success', 'Announcement successfully');
    }
}
