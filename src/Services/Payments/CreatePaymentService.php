<?php

namespace App\Services\Payments;

use App\Entities\Payment;
use App\Exceptions\GeneralException;
use App\Services\Payments\Commands\CreatePaymentCommand;
use App\Services\Payments\Commission\CommissionService;

class CreatePaymentService
{
    /**
     * @param CreatePaymentCommand $command
     *
     * @return Payment
     *
     * @throws GeneralException
     */
    public function handle(CreatePaymentCommand $command): Payment
    {
        $commissionService = new CommissionService($command);
        return new Payment($commissionService->getAmount(), $commissionService->getCommission(), $command->getPaymentMethod(), $command->getBank());
    }
}