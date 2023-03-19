<?php

namespace App\Http\Requests\Todo;

use Illuminate\Foundation\Http\FormRequest;

class RequestStore extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        $rules = [
            'task' => ['required', 'min:5', 'unique:todo,task']
        ];

        return $rules;
    }

    public function messages(): array
    {
        $messages = [
            'task.required' => 'Vui lòng nhập Task !',
            'task.unique' => 'Tên Task đã tồn tại !',
            'task.min' => 'Tên Task không được dưới 5 kí tự'
        ];

        return $messages;
    }
}
