<?php


namespace App\Banks;


use App\Banks\Responses\Payment;
use App\Exceptions\BankException;
use App\Exceptions\TimeoutException;
use App\PaymentMethods\Card;
use App\PaymentMethods\PaymentMethod;
use App\PaymentMethods\QiWi;
use Money\Money;

class Sberbank implements BankInterface
{
    /**
     * @param Money $amount
     *
     * @param PaymentMethod $paymentMethod
     *
     * @return Payment
     *
     * @throws BankException|TimeoutException
     */
    public function createPayment(Money $amount, PaymentMethod $paymentMethod): Payment
    {
        switch ($paymentMethod->getClassName()) {
            case Card::class:
                /** @var Card $paymentMethod */
                return $this->createCardPayment($amount, $paymentMethod);
            case QiWi::class:
                /** @var QiWi $paymentMethod */
                return $this->createQiWiPayment($amount, $paymentMethod);
        }
        return new Payment(Payment::STATUS_FAILED);
    }

    /**
     * @param Money $amount
     *
     * @param Card $card
     *
     * @return Payment
     */
    protected function createCardPayment(Money $amount, Card $card): Payment
    {
        return new Payment(Payment::STATUS_COMPLETED);
    }

    /**
     * @param Money $amount
     *
     * @param QiWi $qiwi
     *
     * @return Payment
     */
    protected function createQiWiPayment(Money $amount, QiWi $qiwi): Payment
    {
        return new Payment(Payment::STATUS_COMPLETED);
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return self::SBERBANK;
    }
}