<?php
/** @noinspection PhpUnused */

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class EntryRequest
 * @package App\Http\Requests
 */
class StudentsRequest extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array {
        return [
            'id' => 'nullable|exists:App\Models\Students,id',
            'lastname' => 'required|string|max:128',
            'firstname' => 'required|string|max:128',
            'secondname' => 'string|max:128',
            'age' => 'required|integer|min:18|max:27',
            'email' => 'email:rfc,dns',
            'characteristic' => 'string|nullable',
            'courses_teachers' => 'array|keysExists:App\Models\Courses,id',
            'courses_teachers.*' => 'exists:App\Models\Teachers,id',
        ];
    }

    /**
     * @return array
     */
    public function messages(): array {
        return [
            'lastname.required' => 'Поле "Фамилия" не может быть пустым!',
            'firstname.required' => 'Поле "Имя" не может быть пустым!',
            'age.required' => 'Поле "Возраст" не может быть пустым!',

            'age.min' => 'Возраст не может быть меньше 18',

            'lastname.max' => 'Поле "Фамилия" не может быть длиннее 128 символов!',
            'firstname.max' => 'Поле "Имя" не может быть длиннее 128 символов!',
            'secondname.max' => 'Поле "Отчество" не может быть длиннее 128 символов!',
            'age.max' => 'Возраст не может быть больше 27',

            'email.email' => 'Поле "Email" должно являться email`ом',
        ];
    }
}
