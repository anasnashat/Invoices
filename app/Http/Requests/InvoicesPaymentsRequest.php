<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InvoicesPaymentsRequest extends FormRequest
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
            'invoice_id' => 'required|exists:invoices,id',
            'payment_amount' => 'required|numeric|between:0,999999.99',
            'note' => 'nullable|string'
        ];
    }
    public function messages()
    {
        return [
            'invoice_id.required' => 'حقل معرف الفاتورة مطلوب.',
            'invoice_id.exists' => 'معرف الفاتورة غير موجود.',
            'user_id.required' => 'حقل معرف المستخدم مطلوب.',
            'user_id.exists' => 'معرف المستخدم غير موجود.',
            'payment_amount.required' => 'حقل مبلغ الدفع مطلوب.',
            'payment_amount.numeric' => 'يجب أن يكون مبلغ الدفع رقميًا.',
            'payment_amount.between' => 'يجب أن يكون مبلغ الدفع بين 0 و 999999.99.',
            'difference.required' => 'حقل الفرق مطلوب.',
            'difference.numeric' => 'يجب أن يكون الفرق رقميًا.',
            'difference.between' => 'يجب أن يكون الفرق بين -999999.99 و 999999.99.',
            'note.required' => 'حقل الملاحظة مطلوب.',
            'note.string' => 'يجب أن تكون الملاحظة نصية.'
        ];
    }
}
