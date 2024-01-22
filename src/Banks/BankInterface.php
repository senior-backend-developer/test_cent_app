<?php

namespace App\Banks;

use App\Banks\Responses\Payment;
use App\Entities\Interfaces\NameInterface;
use App\Exceptions\BankException;
use App\Exceptions\TimeoutException;
use App\PaymentMethods\PaymentMethod;
use Money\Money;

interface BankInterface extends NameInterface
{
    public const SBERBANK = 'sberbank';
    public const TINKOFF = 'tinkoff';

    /**
     * @param Money $amount
     *
     * @param PaymentMethod $paymentMethod
     *
     * @return Payment
     *
     * @throws BankException|TimeoutException
     */
    public function createPayment(Money $amount, PaymentMethod $paymentMethod): Payment;
}