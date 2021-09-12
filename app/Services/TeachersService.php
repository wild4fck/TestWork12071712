<?php /** @noinspection PhpUndefinedMethodInspection */

namespace App\Services;

use App\Models\Courses;
use App\Models\Teachers;
use Exception;
use Illuminate\Http\JsonResponse;

class TeachersService {

    /**
     * @param array $data
     * @return \Illuminate\Http\JsonResponse
     */
    public static function create(array $data): JsonResponse {
        $teacher = Teachers::create($data);

        self::saveCourses($data['courses'], $teacher);

        return NotifyService::notify('Добавление завершено',
            'Добавлен новый преподаватель - ' . $teacher->getFullName());
    }

    /**
     * @param array $courses
     * @param \App\Models\Teachers $teacher
     */
    private static function saveCourses(array $courses, Teachers $teacher) {
        foreach ($courses as $courseId) {
            try {
                $teacher->courses()->save(Courses::find($courseId));
            } catch (Exception $exception) {
                logger($exception->getMessage());
            }
        }
    }

    /**
     * @param array $data
     * @return \Illuminate\Http\JsonResponse
     */
    public static function update(array $data): JsonResponse {
        $teacher = Teachers::find($data['id']);
        $teacher->update($data);

        $teacher->courses()->detach();

        self::saveCourses($data['courses'], $teacher);

        return NotifyService::notify('Обновление завершено',
            'Данные преподавателя ' . $teacher->getFullName() . ' изменены');
    }
}
