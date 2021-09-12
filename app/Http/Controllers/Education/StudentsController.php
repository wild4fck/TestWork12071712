<?php

namespace App\Http\Controllers\Education;

use App\Http\Controllers\Controller;
use App\Http\Requests\StudentsRequest;
use App\Models\Students;
use App\Services\StudentsService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class StudentsController extends Controller {

    private $student;

    public function __construct() {
        $this->student = new Students;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getStudents(): JsonResponse {
        return response()->json($this->student->orderBy('lastname')->with('coursesTeachers')->get());
    }

    /**
     * @param StudentsRequest $request
     * @return JsonResponse
     */
    public function add(StudentsRequest $request): JsonResponse {
        return StudentsService::create($request->all());
    }

    /**
     * @param StudentsRequest $request
     * @return JsonResponse
     */
    public function edit(StudentsRequest $request): JsonResponse {
        return StudentsService::update($request->all());
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request): JsonResponse {
        $validated = $request->validate([
            'id' => 'required|exists:App\Models\Students,id',
        ]);
        return response()->json($this->student->find($validated['id'])->delete());
    }
}
