<?php

namespace App\Services;

use App\Models\CoursesTeachers;
use App\Models\Students;
use Exception;
use Illuminate\Http\JsonResponse;

class StudentsService {

    /**
     * @param array $data
     * @return \Illuminate\Http\JsonResponse
     */
    public static function create(array $data): JsonResponse {
        $student = Students::create($data);

        self::saveCoursesTeachers($data['courses_teachers'], $student);

        return NotifyService::notify('Добавление завершено',
            'Добавлен новый студент - ' . $student->getFullName());
    }

    /**
     * @param array $coursesTeachers
     * @param \App\Models\Students $student
     */
    private static function saveCoursesTeachers(array $coursesTeachers, Students $student) {
        foreach ($coursesTeachers as $courseId => $teacherId) {
            try {
                $courseTeacher = CoursesTeachers::whereHas('course', function ($query) use ($courseId) {
                    $query->whereId($courseId);
                })->whereHas('teacher', function ($query) use ($teacherId) {
                    $query->whereId($teacherId);
                })->first();
                $student->coursesTeachers()->save($courseTeacher);
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
        $student = Students::find($data['id']);
        $student->update($data);

        $student->coursesTeachers()->detach();

        self::saveCoursesTeachers($data['courses_teachers'], $student);

        return NotifyService::notify('Обновление завершено',
            'Данные студента ' . $student->getFullName() . ' изменены');
    }
}
