<?php


namespace App\PaymentMethods;


class QiWi extends PaymentMethod
{

    private string $phone_number;

    public function __construct(string $phone_number)
    {
        $this->phone_number = $phone_number;
    }

    /**
     * @return string
     */
    public function getPhoneNumber(): string
    {
        return $this->phone_number;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return self::QIWI;
    }
}