<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InvoicesRequest extends FormRequest
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
            'invoice_number' => 'required|string',
            'invoice_date' => 'required|date',
            'due_date' => 'required|date',
            'product_id' => 'nullable|exists:products,id',
            'section_id' => 'nullable|exists:sections,id',
            'rate_vat' => 'required|string',
            'value_vat' => 'required|numeric',
            'total' => 'required|numeric',
            'amount_commission' => 'nullable|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
            'amount_collection' => 'nullable|numeric|min:0',
            'not' => 'nullable|string',
        ];
    }

    public function messages()
    {
        return [
            'invoices_number.required' => 'حقل رقم الفاتورة مطلوب',
            'invoice_date.required' => 'حقل تاريخ الفاتورة مطلوب',
            'due_date.required' => 'حقل تاريخ الاستحقاق مطلوب',
            'product_id.exists' => 'المنتج المحدد غير موجود',
            'section_id.exists' => 'القسم المحدد غير موجود',
            'rate_vat.required' => 'حقل سعر الضريبة مطلوب',
            'value_vat.required' => 'حقل قيمة الضريبة مطلوب',
            'amount_commission.numeric' => 'حقل قيمة العمولة يجب أن يكون رقمًا',
            'discount.numeric' => 'حقل الخصم يجب أن يكون رقمًا',
            'total.required' => 'حقل الإجمالي مطلوب',
            'total.numeric' => 'حقل الإجمالي يجب أن يكون رقمًا',
            'status.required' => 'حقل الحالة مطلوب',
            'amount_collection.numeric' => 'حقل قيمة التحصيل يجب أن يكون رقمًا',
        ];
    }
}
