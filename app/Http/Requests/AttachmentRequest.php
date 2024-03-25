<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AttachmentRequest extends FormRequest
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
            'invoice_id' => 'required|integer|exists:invoices,id',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ];
    }
    public function messages()
    {
        return [
            'invoice_id.required' => 'حقل معرف الفاتورة مطلوب.',
            'invoice_id.integer' => 'يجب أن يكون معرف الفاتورة عددًا صحيحًا.',
            'invoice_id.exists' => 'معرف الفاتورة غير موجود.',
            'attachment.nullable' => 'حقل المرفق اختياري.',
            'attachment.file' => 'يجب أن يكون المرفق ملفًا.',
            'attachment.mimes' => 'يجب أن يكون المرفق من نوع: jpg, jpeg, png, pdf.',
            'attachment.max' => 'يجب ألا يتجاوز حجم المرفق 2048 كيلوبايت.',
        ];
    }
}
