<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'product_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'section_id' => 'required|exists:sections,id',
        ];
    }

    public function messages()
    {
        return [
            'product_name.required' => 'حقل اسم المنتج مطلوب.',
            'product_name.string' => 'يجب أن يكون اسم المنتج نصًا.',
            'product_name.max' => 'يجب ألا يزيد اسم المنتج عن 255 حرفًا.',
            'description.string' => 'يجب أن تكون الوصف نصًا.',
            'section_id.required' => 'حقل القسم مطلوب.',
            'section_id.exists' => 'القسم المحدد غير صالح.',
        ];

    }
}
