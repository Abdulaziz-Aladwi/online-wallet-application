<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Queue;
use App\Jobs\Webhooks\ProcessTransactionJob;

class ReceivePaymmentNotificationApiTest extends TestCase
{
    const RECEIVE_PAYMENT_NOTIFICATION_URL = 'api/integration/webhook/receive-payment-notification';

    public function test_dispatches_transactions_parser_job()
    {
        Queue::fake();

        $data = [
            "20250615156,50#202506159000002#note/debt payment march /internal_reference/A462JE81",
            "20250616100,00#202506159000003#note/rent internal_reference/B583KD92"
        ];

        $response = $this->postJson(self::RECEIVE_PAYMENT_NOTIFICATION_URL, $data);

        $response->assertStatus(200);
        Queue::assertPushed(ProcessTransactionJob::class);
    }
}
