<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;

class TeacherController extends Controller
{
    /**
     * showing a list of teachers
     */
    public function index() {
        $teachers = User::where('role', User::ROLE_TEACHER)->orderBy('created_at','desc')->simplePaginate(10);
        return view('teacher.index', [
            'teachers' => $teachers
        ]);
    }

    /**
     * View add teacher page.
     */
    public function createView() {
        return view('teacher.add');
    }

    /**
     * create a teacher
     */
    public function saveTeacher(Request $request) {
        $request->validate([
            'name' => ['required', 'string', 'max:40'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'mobile' => ['digits:10'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'password' => Hash::make($request->password),
        ]);

        return redirect(route('teacher.list'));
    }

    /**
     * @param $id
     * get data from db and show edit screen
     */
    public function editView($id) {
        $teacher = User::where('role',User::ROLE_TEACHER)->where('id', $id)->first();
        if ($teacher) {
            return view('teacher.edit', [
                'teacher' => $teacher
            ]);
        }
        return back();
    }

    /**
     * @param Request $request
     * update a teacher
     */
    public function editTeacher(Request $request) {
        $request->validate([
            'id' => ['required', Rule::exists('users', 'id')->where('role', User::ROLE_TEACHER)],
            'name' => ['required', 'string', 'max:40'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')->whereNot('id', $request->id)],
            'mobile' => ['digits:10']
        ]);

        User::where('id', $request->id)->update([
            'name' => $request->name,
            'email' => $request->email,
            'mobile' => $request->mobile
        ]);

        return redirect(route('teacher.list'));
    }

    /**
     * @param $id
     * @param Request $request
     * delete requested teacher
     */
    public function delete($id, Request $request) {
        validator($request->route()->parameters(), [
            'id' => ['required', Rule::exists('users', 'id')->where('role', User::ROLE_TEACHER)],
        ])->validate();

        User::where('id', $request->id)->delete();
        return redirect(route('teacher.list'));
    }
}
