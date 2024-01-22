<?php

namespace App\Services\Payments\Commission;

use App\Exceptions\GeneralException;
use App\Models\Fee;
use App\Repositories\FeeRepository;
use App\Services\Money\MoneyService;
use App\Services\Payments\Commands\CreatePaymentCommand;
use Exception;
use Money\Money;

class CommissionService
{
    private ?Money $_amountWithCommission = null;
    private ?Money $_commission = null;
    private MoneyService $moneyService;
    private array $fees;
    private Fee $fee;
    private int $requestAmount;
    private string $currency;

    public function __construct(CreatePaymentCommand $command)
    {
        $feeRepository = new FeeRepository();
        $this->fees = $feeRepository->getFeesFromCommand($command);

        $moneyAmount = $command->getAmount();
        $this->requestAmount = (int)$moneyAmount->getAmount();
        $this->currency = $moneyAmount->getCurrency()->getCode();

        $this->moneyService = new MoneyService();
    }

    /**
     * @return Money
     *
     * @throws GeneralException
     */
    public function getCommission(): Money
    {
        if (is_null($this->_commission)) {
            $this->calculateCommissionAndAmount();
        }
        return $this->_commission;
    }

    /**
     * @return Money
     *
     * @throws GeneralException
     */
    public function getAmount(): Money
    {
        if (is_null($this->_amountWithCommission)) {
            $this->calculateCommissionAndAmount();
        }
        return $this->_amountWithCommission;
    }

    /**
     * @return void
     *
     * @throws GeneralException
     */
    private function calculateCommissionAndAmount(): void
    {
        foreach ($this->fees as $fee) {
            $this->fee = $fee;
            $commission = $this->calculateCommission();
            $calculatedAmount = $this->calculateAmount($commission);

            if ($this->isAmountInRange($calculatedAmount)) {
                $this->checkCommission($calculatedAmount);
                $this->_commission = $this->moneyService->createMoney($this->currency, $commission);
                $this->_amountWithCommission = $this->moneyService->createMoney($this->currency, $calculatedAmount);
                return;
            }
        }
        throw new GeneralException('Нет подходящего тарифа!');
    }

    /**
     * @throws Exception
     */
    private function calculateAmount(int $commission): int
    {
        return $this->requestAmount + $commission;
    }

    /**
     * @return int
     */
    private function calculateCommission(): int
    {
        $feePercent = $this->fee->fee_percent / 100;
        $feeFix = $this->fee->fee_fix;
        $feeMin = $this->fee->fee_min;

        $amount = $this->requestAmount / (1 - $feePercent);
        return (int)max($amount * $feePercent + $feeFix, $feeMin);
    }

    /**
     * @param int $calculatedAmount
     *
     * @return bool
     */
    private function isAmountInRange(int $calculatedAmount): bool
    {
        return $calculatedAmount >= $this->moneyService->removePennies($this->fee->amount_min)
            && $calculatedAmount < $this->moneyService->removePennies($this->fee->amount_max);
    }

    /**
     * @param int $commission
     *
     * @return void
     *
     * @throws GeneralException
     */
    private function checkCommission(int $commission): void
    {
        if ($commission <= 0) {
            throw new GeneralException('Ошибка расчетов!');
        }
    }
}