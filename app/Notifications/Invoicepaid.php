<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class Invoicepaid extends Notification
{
    use Queueable;
    protected $payment;

    /**
     * Create a new notification instance.
     */
    public function __construct($payment)
    {
        $this->payment = $payment;
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
//        dd($this->payment);
        return (new MailMessage)
            ->subject('تم دفع فاتوره جديده')
            ->line('رقم الفاتوره : '.$this->payment->invoice->invoice_number)
            ->line('الموظف المسؤل عن عمليه الدفع : '.$this->payment->user->name)
            ->line(' مبلغ الكلي للتحصيل : '.$this->payment->invoice->total)
            ->line(' المدفوع  : '.$this->payment->payment_amount)
            ->line(' المبلغ المتبقي : '.$this->payment->difference)
            ->action('عرض الفاتوره', route('invoices.show', $this->payment->invoice))
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
