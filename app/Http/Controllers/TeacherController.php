<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreMarkRequest;
use App\Http\Resources\CourseUserResource;
use App\Http\Resources\TaskResource;
use App\Models\Course;
use App\Models\CourseUser;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    //api to add student per class, teacher_student table
    public function addStudent(StoreMarkRequest $request): string|CourseUserResource
    {
        $validated = $request->validated();
        $course = Course::find($validated['course_id']);
        $user_id = auth()->user()->id;
        $this->authorize('create', $course);
        if (User::where('id', $validated['user_id'])->exists()) {
            $teacher = User::find($user_id);
            $teacher->courses()->attach($validated['user_id'], ['course_id' => $validated['course_id']]);

            return new CourseUserResource($course);
        }

        return 'Student not registered';
    }

    public function editMark(StoreMarkRequest $request): CourseUserResource
    {
        $validated = $request->validated();
        $mark = CourseUser::find($validated['user_id']);
        $this->authorize('update', $mark);
        $mark = CourseUser::where('user_id', $validated['user_id'])
                            ->where('course_id', $validated['course_id'])
                            ->update([
                                'first' => $validated['first'],
                                'mid' => $validated['mid'],
                                'final' => $validated['final'],
                            ]);

        return new CourseUserResource($mark);
    }

    public function addTask(Request $request): TaskResource
    {
        $validated = $request->validate([
            'path' => ['required', 'mimes:pptx,pdf'],
            'course_id' => 'required',
        ]);
        $task = new Task;
        $course = Course::find($validated['course_id']);
        $this->authorize('create', [$course, $task]);
        $title = $request->file('path')->getClientOriginalName();
        $path = $request->file('path')->store('public/files');
        $save = new Task;
        $save->title = $title;
        $save->path = $path;
        $save->course_id = $request->course_id;
        $save->save();

        return new TaskResource($save);
    }
}
