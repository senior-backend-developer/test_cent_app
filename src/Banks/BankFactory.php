<?php

namespace App\Banks;

use App\Exceptions\GeneralException;

class BankFactory
{
    /**
     * Возвращает сущность от BankInterface, по имени банка
     *
     * @param string $bankName
     *
     * @return BankInterface
     *
     * @throws GeneralException
     */
    public static function getBank(string $bankName): BankInterface
    {
        switch ($bankName) {
            case BankInterface::SBERBANK:
                return new Sberbank();
            case BankInterface::TINKOFF:
                return new Tinkoff();
            default:
                throw new GeneralException('Банк не найден');
        }
    }
}