<?php


namespace App\Entities;


use App\Banks\BankInterface;
use App\PaymentMethods\PaymentMethod;
use DateTime;
use Money\Money;

class Payment
{

    private Money $amount;
    private Money $commission;
    private PaymentMethod $paymentMethod;
    private DateTime $createdAt;
    private BankInterface $bank;

    public function __construct(Money $amount, Money $commission, PaymentMethod $paymentMethod, BankInterface $bank)
    {
        $this->amount = $amount;
        $this->commission = $commission;
        $this->paymentMethod = $paymentMethod;
        $this->createdAt = new DateTime();
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
     * @return Money
     */
    public function getCommission(): Money
    {
        return $this->commission;
    }

    /**
     * @return PaymentMethod
     */
    public function getPaymentMethod(): PaymentMethod
    {
        return $this->paymentMethod;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    /**
     * @return Money
     */
    public function getNetAmount(): Money
    {
        return $this->amount->subtract($this->commission);
    }

    /**
     * @return BankInterface
     */
    public function getBank(): BankInterface
    {
        return $this->bank;
    }
}