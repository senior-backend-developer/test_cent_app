<?php

namespace App\Services\Money;

use Money\Money;

class MoneyService
{
    /**
     * @param float $amount
     *
     * @return int
     */
    public function removePennies(float $amount): int
    {
        return (int)($amount * 100);
    }

    /**
     * @param string $currency
     *
     * @param int $amount
     *
     * @return Money
     */
    public function createMoney(string $currency, int $amount): Money
    {
        return Money::$currency($amount);
    }
}