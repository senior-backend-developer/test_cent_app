<?php

namespace App\Repository;


use App\Models\Fee;
use App\Services\Payments\Commands\CreatePaymentCommand;

class FeeRepository
{
    /**
     * @param CreatePaymentCommand $command
     *
     * @return Fee[]
     */
    public function getFeesFromCommand(CreatePaymentCommand $command): array
    {
        return Fee::find()
            ->where([
                'bank' => $command->getBank()->getName(),
                'payment_method' => $command->getPaymentMethod()->getName(),
                'currency_iso' => $command->getAmount()->getCurrency(),
            ])->all();
    }
}