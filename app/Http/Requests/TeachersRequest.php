<?php
/** @noinspection PhpUnused */

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class EntryRequest
 * @package App\Http\Requests
 */
class TeachersRequest extends FormRequest {
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
            'id' => 'nullable|exists:App\Models\Teachers,id',
            'lastname' => 'required|string|max:128',
            'firstname' => 'required|string|max:128',
            'secondname' => 'string|max:128',
            'email' => 'email:rfc,dns',
            'courses' => 'array',
            'courses.*' => 'exists:App\Models\Courses,id',
        ];
    }

    /**
     * @return array
     */
    public function messages(): array {
        return [
            'lastname.required' => 'Поле "Фамилия" не может быть пустым!',
            'firstname.required' => 'Поле "Имя" не может быть пустым!',

            'lastname.max' => 'Поле "Фамилия" не может быть длиннее 128 символов!',
            'firstname.max' => 'Поле "Имя" не может быть длиннее 128 символов!',
            'secondname.max' => 'Поле "Отчество" не может быть длиннее 128 символов!',

            'email.email' => 'Поле "Email" должно являться email`ом',
        ];
    }
}
