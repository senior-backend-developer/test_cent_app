<?php

namespace App\Services\Notifications;

use App\Entities\CurrencyBook;
use App\Entities\Payment;
use App\PaymentMethods\QiWi;
use App\Services\Notifications\Message\PaymentSuccessMessage;

class PaymentSuccessNotificationService
{
    protected NotificationService $notificationService;

    public function __construct()
    {
        $this->notificationService = new NotificationService();
    }

    /**
     * Отправка уведомления об успешном платеже
     *
     * @param Payment $payment
     *
     * @return void
     */
    public function handle(Payment $payment)
    {
        if ($this->dispatchRule($payment)) {
            $this->notificationService->dispatch(new PaymentSuccessMessage());
        }
    }

    /**
     * Проверка условий для отправки уведомления
     *
     * @param Payment $payment
     *
     * @return bool
     */
    protected function dispatchRule(Payment $payment): bool
    {
        if ($payment->getPaymentMethod()->getClassName() === QiWi::class ||
            $payment->getAmount()->getCurrency()->getCode() === CurrencyBook::EUR) {
            return true;
        }
        return false;
    }
}