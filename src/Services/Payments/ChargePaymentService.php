<?php

namespace App\Services\Payments;

use App\Entities\Payment;
use App\Exceptions\BankException;
use App\Exceptions\TimeoutException;

class ChargePaymentService
{
    /**
     * @param Payment $payment
     *
     * @return \App\Banks\Responses\Payment
     *
     * @throws BankException|TimeoutException
     */
    public function handle(Payment $payment): \App\Banks\Responses\Payment
    {
        return $payment->getBank()->createPayment($payment->getAmount(), $payment->getPaymentMethod());
    }
}