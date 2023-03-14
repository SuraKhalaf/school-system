<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Resources\CourseCollection;
use App\Http\Resources\CourseNameCollection;
use App\Models\Course;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Gate;

class CourseController extends Controller
{
    public function show(): CourseCollection
    {
        $course = new Course;
        Gate::authorize('view', [$course]);

        return new CourseCollection(Course::all());
    }

    public function showStudentClass($id): CourseNameCollection
    {
        $user = auth()->user();
        $course = new Course;
        Gate::authorize('view', [$user, $course]);
        $courses_name = Course::whereHas('students', function (Builder $query) use ($id) {
            $query->where('user_id', $id);
        })->get();

        return new CourseNameCollection($courses_name);
    }

    public function showTeacherClass($id): CourseNameCollection
    {
        $user = auth()->user();
        $course = new Course;

        // Gate::authorize('update', [$user, $course]);
        //$this->authorize('update', [$user, $course]);
        Gate::authorize('view', [$user, $course]);
        $courses_name = Course::where('user_id', $id)->get();

        return new CourseNameCollection($courses_name);
    }
}
