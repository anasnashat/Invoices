<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SectionRequest extends FormRequest
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
        $rules = [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:65535',
        ];

        if ($this->isMethod('post')) {
            $rules['name'] = 'unique:sections';
        } elseif ($this->isMethod('put') || $this->isMethod('patch')) {
            $rules['name'] = Rule::unique('sections')->ignore($this->section);
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'name.required' => 'حقل القسم مطلوب.',
            'name.string' => 'القسم يجب أن يكون نص.',
            'name.unique' => 'القسم موجود مسبقاً، يرجى اختيار اسم آخر.',
            'name.max' => 'القسم لا يجب أن يتجاوز 255 حرف.',
            'description.string' => 'الوصف يجب أن يكون نص.',
            'description.max' => 'الوصف لا يجب أن يتجاوز 65535 حرف.',
            'created_by.required' => 'حقل المستخدم المنشئ مطلوب.',
            'created_by.integer' => 'حقل المستخدم المنشئ يجب أن يكون رقم.',
        ];
    }


}
