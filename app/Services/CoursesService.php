<?php

namespace App\Services;

use App\Models\Courses;
use Illuminate\Http\JsonResponse;

class CoursesService {

    /**
     * @param array $data
     * @return \Illuminate\Http\JsonResponse
     */
    public static function create(array $data): JsonResponse {
        $course = Courses::create($data);

        return NotifyService::notify('Добавление завершено',
            'Добавлен новый курс - ' . $course->name);
    }

    /**
     * @param array $data
     * @return \Illuminate\Http\JsonResponse
     */
    public static function update(array $data): JsonResponse {
        $course = Courses::find($data['id']);
        $course->update($data);

        return NotifyService::notify('Обновление завершено',
            'Данные курса ' . $course->name . ' изменены');
    }
}
