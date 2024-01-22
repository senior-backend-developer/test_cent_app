<?php

namespace App\PaymentMethods;

use App\Entities\Interfaces\NameInterface;

abstract class PaymentMethod implements NameInterface
{
    public const CARD = 'card';
    public const QIWI = 'qiwi';

    /**
     * @return string
     */
    public function getClassName(): string
    {
        return static::class;
    }
}