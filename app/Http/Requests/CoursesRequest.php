<?php
/** @noinspection PhpUnused */

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class EntryRequest
 * @package App\Http\Requests
 */
class CoursesRequest extends FormRequest {
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
            'id' => 'nullable|exists:App\Models\Courses,id',
            'name' => 'required|string|max:128',
            'description' => 'string',
        ];
    }

    /**
     * @return array
     */
    public function messages(): array {
        return [
            'name.required' => 'Поле "Фамилия" не может быть пустым!',
            'name.max' => 'Поле "Фамилия" не может быть длиннее 128 символов!',
        ];
    }
}
