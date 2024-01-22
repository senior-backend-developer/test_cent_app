<?php

use App\Banks\BankFactory;
use App\Banks\BankInterface;
use App\Entities\ResponseMessages;
use App\Exceptions\BankException;
use App\Exceptions\GeneralException;
use App\Exceptions\TimeoutException;
use App\PaymentMethods\Card;
use App\Services\Notifications\PaymentSuccessNotificationService;
use App\Services\Payments\ChargePaymentService;
use App\Services\Payments\Commands\CreatePaymentCommand;
use App\Services\Payments\CreatePaymentService;
use Money\Money;

require_once './vendor/autoload.php';

$message = ResponseMessages::DEFAULT_ERROR;

try {
    $createPaymentService = new CreatePaymentService();
    $paymentMethod = new Card('4242424242424242', new \DateTime('2021-10-15'), 123);
    //$paymentMethod = new QiWi('89005555555');
    $bank = BankFactory::getBank(BankInterface::TINKOFF);
    $payment = $createPaymentService->handle(new CreatePaymentCommand(Money::RUB(1500000), $paymentMethod, $bank));
    $chargePaymentService = new ChargePaymentService();
    $response = $chargePaymentService->handle($payment);

    if ($response->isCompleted()) {
        $notificationService = new PaymentSuccessNotificationService();
        $notificationService->handle($payment);
        $message = ResponseMessages::SUCCESS;
    }
} catch (BankException $e) {
    $message = ResponseMessages::BANK_ERROR;
} catch (TimeoutException $e) {
    $message = ResponseMessages::TIMEOUT_ERROR;
} catch (GeneralException|Exception|Throwable $e) {
    // log
}

echo $message;
echo PHP_EOL;