<?php

namespace App\Http\Controllers\Education;

use App\Http\Controllers\Controller;
use App\Http\Requests\TeachersRequest;
use App\Models\Teachers;
use App\Services\TeachersService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TeachersController extends Controller {

    private $teacher;

    public function __construct() {
        $this->teacher = new Teachers;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getTeachers(): JsonResponse {
        return response()->json($this->teacher->orderBy('lastname')->with('courses')->get());
    }

    /**
     * @param TeachersRequest $request
     * @return JsonResponse
     */
    public function add(TeachersRequest $request): JsonResponse {
        return TeachersService::create($request->all());
    }

    /**
     * @param TeachersRequest $request
     * @return JsonResponse
     */
    public function edit(TeachersRequest $request): JsonResponse {
        return TeachersService::update($request->all());
    }


    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request): JsonResponse {
        $validated = $request->validate([
            'id' => 'required|exists:App\Models\Teachers,id',
        ]);
        return response()->json($this->teacher->find($validated['id'])->delete());
    }
}
