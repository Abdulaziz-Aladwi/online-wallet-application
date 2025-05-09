<?php

namespace Tests\Feature;

use App\Jobs\Integration\BuildPaymentXmlBodyJob;
use Tests\TestCase;
use Illuminate\Support\Facades\Queue;
use App\Jobs\Webhooks\ProcessTransactionJob;

class SendPaymentApiTest extends TestCase
{
    const SEND_PAYMENT_URL = 'api/integration/send-payment';

    public function test_dispatches_transactions_parser_job()
    {
        Queue::fake();

        $requestData = $this->getSampleReauestData();
        $response = $this->postJson(self::SEND_PAYMENT_URL, $requestData);

        $response->assertStatus(200);
        Queue::assertPushed(BuildPaymentXmlBodyJob::class);
    }

    private function getSampleReauestData()
    {
        return [
            'amount' => 1,
            'currency' => 'SAR',
            'account_number' => 'SA6980000204608016212908',
            'beneficiary_name' => 'Jane Doe',
            'beneficiary_bank_code' => 'FDCSSARI',
            'beneficiary_account_number' => 'SA6980000204608016211111',
            'payment_type' => '421',
            'charge_details' => 'RB',
            'notes' => [
                'test1',
                'test2',
            ],
        ];
    }
}
