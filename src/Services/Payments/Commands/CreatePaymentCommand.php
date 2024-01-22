<?php


namespace App\Services\Payments\Commands;


use App\Banks\BankInterface;
use App\PaymentMethods\PaymentMethod;
use Money\Money;

class CreatePaymentCommand
{

    private Money $amount;
    private PaymentMethod $paymentMethod;
    private BankInterface $bank;

    public function __construct(Money $amount, PaymentMethod $paymentMethod, BankInterface $bank)
    {
        $this->amount = $amount;
        $this->paymentMethod = $paymentMethod;
        $this->bank = $bank;
    }

    /**
     * @return Money
     */
    public function getAmount(): Money
    {
        return $this->amount;
    }

    /**
     * @return PaymentMethod
     */
    public function getPaymentMethod(): PaymentMethod
    {
        return $this->paymentMethod;
    }

    /**
     * @return BankInterface
     */
    public function getBank(): BankInterface
    {
        return $this->bank;
    }
}