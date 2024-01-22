<?php

namespace App\Models;

use App\Banks\BankInterface;
use App\PaymentMethods\PaymentMethod;

class Fee
{
    public string $bank;
    public string $payment_method;
    public string $currency_iso;
    public float $amount_min; // если в бд хранится прям "1 — 1000 RUB", то требуется метод по парсингу данных, желательно на уровне SQL
    public float $amount_max;
    public float $fee_percent;
    public float $fee_fix;
    public float $fee_min;

    /**
     * @return Fee
     */
    public static function find(): Fee
    {
        return new self();
    }

    /**
     * @param array $attributes
     *
     * @return $this
     */
    public function where(array $attributes): self
    {
        // Эмуляция ленивого запроса

        $this->bank = $attributes['bank'];
        $this->payment_method = $attributes['payment_method'];
        $this->currency_iso = $attributes['currency_iso'];

        return $this;
    }

    /**
     * @return Fee[]
     */
    public function all(): array
    {
        // Эмуляция запроса в БД на получение коллекции

        $all = [];

        $pattern = new self();
        $pattern->bank = $this->bank ?? '';
        $pattern->payment_method = $this->payment_method ?? '';
        $pattern->currency_iso = $this->currency_iso ?? '';

        if ($this->bank === BankInterface::SBERBANK && $this->payment_method === PaymentMethod::CARD) {
            $one = clone $pattern;
            $one->amount_min = 1;
            $one->amount_max = 1000;
            $one->fee_percent = 4;
            $one->fee_fix = 1;
            $one->fee_min = 3;

            $two = new self();
            $two->amount_min = 1000;
            $two->amount_max = 10000;
            $two->fee_percent = 3;
            $two->fee_fix = 1;
            $two->fee_min = 3;

            $all[] = $one;
            $all[] = $two;
        }

        if ($this->bank === BankInterface::SBERBANK && $this->payment_method === PaymentMethod::QIWI) {
            $one = clone $pattern;
            $one->amount_min = 1;
            $one->amount_max = 75000;
            $one->fee_percent = 7;
            $one->fee_fix = 1;
            $one->fee_min = 4;
            $all[] = $one;
        }

        if ($this->bank === BankInterface::TINKOFF && $this->payment_method === PaymentMethod::CARD) {
            $one = clone $pattern;
            $one->amount_min = 15000;
            $one->amount_max = 10000000000;
            $one->fee_percent = 2.5;
            $one->fee_fix = 1;
            $one->fee_min = 3;
            $all[] = $one;
        }
        return $all;
    }
}