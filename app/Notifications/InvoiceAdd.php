<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class InvoiceAdd extends Notification
{
    use Queueable;
    protected $invoice;


    /**
     * Create a new notification instance.
     */
    public function __construct($invoice)
    {
        $this->invoice = $invoice;

    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->subject('تم اضافه فاتوره جديده')
                    ->line('رقم الفاتوره : '.$this->invoice->invoice_number)
                    ->line('الموظف المسؤل عن عمليه الاضافه : '.$this->invoice->user->name)
                    ->line(' مبلغ التحصيل : '.$this->invoice->total)
                    ->line(' مستحقه في تاريخ : '.$this->invoice->due_date)
                    ->line(' القسم الخاص بالفاتوره: '.$this->invoice->section->name)
                    ->line(' المنتج الخاص بالفاتوره: '.$this->invoice->product->product_name)
                    ->line($this->invoice->rate_vat.'  نسبه الضريبه: ')
                    ->action('عرض الفاتوره', route('invoices.show', $this->invoice))
                    ->line('شكرا علي وقتكم');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
