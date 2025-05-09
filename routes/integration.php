<?php

use App\Http\Controllers\PaymentController;
use App\Http\Controllers\Webhooks\ReceivePaymentNotificationController;
use Illuminate\Support\Facades\Route;

Route::prefix('integration')->group(function () {
    Route::prefix('webhook')->group(function () {
        Route::post('receive-payment-notification', ReceivePaymentNotificationController::class);
    });

    Route::post('send-payment', [PaymentController::class, 'send']);
});
