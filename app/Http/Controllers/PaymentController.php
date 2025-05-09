<?php

namespace App\Http\Controllers;

use App\DTOs\PaymentRequestDto;
use App\Http\Requests\SendPaymentRequest;
use App\Services\Integration\PaymentDispatcherService;
use Symfony\Component\HttpFoundation\Response;

class PaymentController extends Controller
{
    /**
     * @var PaymentDispatcherService
     */
    public function __construct(
        private PaymentDispatcherService $paymentDispatcherService
    ) {}

    /**
     * Send a payment.
     * 
     * @param SendPaymentRequest $request
     * @return void
     */
    public function send(SendPaymentRequest $request)
    {
        $request = $request->validated();   
        $paymentDto = PaymentRequestDto::fromArray($request);
        $this->paymentDispatcherService->dispatch($paymentDto);
        return response()->json(['status' => Response::HTTP_OK]);
    }
}
