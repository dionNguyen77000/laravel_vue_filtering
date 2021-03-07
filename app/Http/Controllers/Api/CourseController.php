<?php

namespace App\Http\Controllers\Api;

use App\Course;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Filters\Course\CourseFilters;
use App\Http\Resources\CourseResource;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        return new CourseResource (
            Course::with(['subjects', 'users'])->latest()->filter($request)->paginate(2)
        );
    }

    public function filters()
    {
        return response()->json([
            'data' => CourseFilters::mappings(),
        ],200);
    }
}
