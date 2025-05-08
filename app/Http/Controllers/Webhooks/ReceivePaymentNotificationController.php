<?php

namespace App\Http\Controllers\Webhooks;

use App\Http\Controllers\Controller;
use App\Services\Webhooks\PaymentTransactionDispatcherService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class ReceivePaymentNotificationController extends Controller
{
    public function __construct(
        private PaymentTransactionDispatcherService $paymentTransactionDispatcherService
    ) {}

    /**
     * Handle the incoming request.
     * 
     * Another way we can do is to parse the transactions first and assign them to DTOs so i can validate and parse them and add them to the job as objects
     * but for now to avoid any early processing, i will just dispatch the transactions as they are and validate & parse later in the job,
     * alghough it will load the job with maybe not consistent data, at the end it's trade off.
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function __invoke(Request $request)
    {
        $transactions = $request->all()['transactions'];
        $this->paymentTransactionDispatcherService->dispatch($transactions);
        Log::info('Transactions dispatched', ['transactions' => $transactions]);
        return response()->json(['status' => Response::HTTP_OK]);
    }
}
