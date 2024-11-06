<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\StudentParent;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ParentController extends Controller
{
    public function index(Request $request) {
        $parents = StudentParent::orderBy('id','desc')->simplePaginate();
        return view('parent.index', [
            'parents' => $parents,
        ]);
    }

    public function createView(Request $request) {
        return view('parent.add');
    }

    public function saveParent(Request $request) {
        $request->validate([
            'name' => ['required', 'string', 'max:40'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.StudentParent::class],
        ]);

        StudentParent::create([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return redirect(route('parent.list'))->with('success', 'Create successfully');
    }

    public function editView($id, Request $request) {
        $parent = StudentParent::where('id', $id)->first();
        if ($parent) {
            return view('parent.edit', [
                'parent' => $parent,
            ]);
        }
        return back()->with('error', 'parent not found');
    }

    /**
     * @param Request $request
     * update a teacher
     */
    public function editParent(Request $request) {
        $request->validate([
            'id' => ['required', Rule::exists('student_parents', 'id')],
            'name' => ['required', 'string', 'max:40'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('student_parents', 'email')->whereNot('id', $request->id)],
        ]);

        StudentParent::where('id', $request->id)->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return redirect()->route('parent.list')->with('success', 'Edit successfully');
    }

    public function delete($id, Request $request) {
        validator($request->route()->parameters(), [
            'id' => ['required', Rule::exists('student_parents', 'id')],
        ])->validate();

        StudentParent::where('id', $request->id)->delete();
        return redirect(route('parent.list'))->with('success', 'Delete successfully');
    }
}
