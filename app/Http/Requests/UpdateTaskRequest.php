<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'completed' => 'required|in:Hoàn thành,Chưa hoàn thành'
        ];
    }

    public function messages(): array
    {
        return [
            'required' => 'Trường :attribute không được để trống',
            'string' => 'Dữ liệu của trường :attribute phải là chuỗi',
            'in' => 'Dữ liệu của trường :attribute chỉ có giá trị là: :values',
            'max' => 'Dữ liệu của trường :attribute cao nhất chỉ có :max giá trị'
        ];
    }

    public function attributes(): array
    {
        return [
            'title' => 'Tiêu đề',
            'description' => 'Mô tả',
            'conpleted' => 'Trạng thái'
        ];
    }
}
