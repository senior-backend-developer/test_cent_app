<?php


namespace App\PaymentMethods;


use DateTime;

class Card extends PaymentMethod
{

    private string $pan;
    private DateTime $expiryDate;
    private int $cvc;

    public function __construct(string $pan, DateTime $expiryDate, int $cvc)
    {
        $this->pan = $pan;
        $this->expiryDate = $expiryDate;
        $this->cvc = $cvc;
    }

    /**
     * @return string
     */
    public function getPan(): string
    {
        return $this->pan;
    }

    /**
     * @return DateTime
     */
    public function getExpiryDate(): DateTime
    {
        return $this->expiryDate;
    }

    /**
     * @return int
     */
    public function getCvc(): int
    {
        return $this->cvc;
    }

    /**
     * @return string
     */
    function getName(): string
    {
        return self::CARD;
    }
}