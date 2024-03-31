<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;

class UsersUpdateRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $this->user->id,
            'password' => 'nullable|min:8',
            'roles_name' => 'required|max:255',
            'status' => 'required|in:active,not_active',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'الاسم مطلوب.',
            'name.string' => 'يجب أن يكون الاسم نصًا.',
            'name.max' => 'يجب ألا يتجاوز الاسم 255 حرفًا.',
            'email.required' => 'البريد الإلكتروني مطلوب.',
            'email.email' => 'يجب أن يكون البريد الإلكتروني صالحًا.',
            'email.max' => 'يجب ألا يتجاوز البريد الإلكتروني 255 حرفًا.',
            'email.unique' => 'البريد الإلكتروني موجود بالفعل.',
            'password.min' => 'يجب أن تحتوي كلمة المرور على الأقل 8 أحرف.',
            'roles_name.required' => 'اسم الدور مطلوب.',
            'roles_name.string' => 'يجب أن يكون اسم الدور نصًا.',
            'roles_name.max' => 'يجب ألا يتجاوز اسم الدور 255 حرفًا.',
            'status.required' => 'الحالة مطلوبة.',
            'status.in' => 'يجب أن تكون الحالة "active" أو "not_active".',
        ];
    }

}
