<?php

use App\Http\Controllers\Webhooks\ReceivePaymentNotificationController;
use Illuminate\Support\Facades\Route;

Route::prefix('webhook')->group(function () {
    Route::post('receive-payment-notification', ReceivePaymentNotificationController::class);
});
