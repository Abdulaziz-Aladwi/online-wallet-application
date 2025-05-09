<?php

namespace Tests\Unit\Factories;

use App\Factories\TransactionParserFactory;
use App\Parsers\Webhooks\AcmeBankTransactionParser;
use App\Parsers\Webhooks\FoodicsBankTransactionParser;
use App\Parsers\Webhooks\TransactionParserInterface;
use Tests\TestCase;

class TransactionParserFactoryTest extends TestCase
{
    protected TransactionParserFactory $factory;

    const FOODICS_TRANSACTION = 'TXN#20250615156,50#202506159000002#note/debt payment march /internal_reference/A462JE81';
    const ACME_TRANSACTION = '156,50//202506159000001//20250615';

    protected function setUp(): void
    {
        parent::setUp();
        $this->factory = new TransactionParserFactory();
    }

    public function test_returns_the_foodics_parser_if_the_transaction_contains_hash()
    {
        $parser = $this->factory->make(self::FOODICS_TRANSACTION);

        $this->assertInstanceOf(FoodicsBankTransactionParser::class, $parser);
        $this->assertInstanceOf(TransactionParserInterface::class, $parser);
    }

    public function test_returns_the_acme_parser_if_the_transaction_contains_double_slash()
    {
        $parser = $this->factory->make(self::ACME_TRANSACTION);

        $this->assertInstanceOf(AcmeBankTransactionParser::class, $parser);
        $this->assertInstanceOf(TransactionParserInterface::class, $parser);
    }
}
