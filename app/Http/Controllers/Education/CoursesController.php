<?php

namespace App\Http\Controllers\Education;

use App\Http\Controllers\Controller;
use App\Http\Requests\CoursesRequest;
use App\Models\Courses;
use App\Services\CoursesService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CoursesController extends Controller {

    private $course;

    public function __construct() {
        $this->course = new Courses;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCourses(): JsonResponse {
        return response()->json($this->course->orderBy('name')->get());
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getWithTeachers(): JsonResponse {
        return response()->json($this->course->has('teachers')->with('teachers')->get());
    }

    /**
     * @param CoursesRequest $request
     * @return JsonResponse
     */
    public function add(CoursesRequest $request): JsonResponse {
        return CoursesService::create($request->all());
    }

    /**
     * @param CoursesRequest $request
     * @return JsonResponse
     */
    public function edit(CoursesRequest $request): JsonResponse {
        return CoursesService::update($request->all());
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request): JsonResponse {
        $validated = $request->validate([
            'id' => 'required|exists:App\Models\Courses,id',
        ]);
        return response()->json($this->course->find($validated['id'])->delete());
    }
}
