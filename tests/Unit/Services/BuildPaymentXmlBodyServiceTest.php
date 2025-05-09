<?php

namespace Tests\Unit\Services;

use App\DTOs\PaymentRequestDto;
use App\Services\Integration\BuildPaymentXmlBodyService;
use Tests\TestCase;
use Illuminate\Pipeline\Pipeline;
use SimpleXMLElement;
use Tests\Traits\PaymentRequestDtoTrait;

class BuildPaymentXmlBodyServiceTest extends TestCase
{
    use PaymentRequestDtoTrait;
    
    public function test_pipeline_builds_xml_structure()
    {
        $paymentDto = $this->getPaymentRequestDto();
        $pipeline = new Pipeline(app());
        $builder = new BuildPaymentXmlBodyService($pipeline);
        $xml = ($builder->execute($paymentDto))->xml;

        $this->assertNotNull($xml);
        $this->assertInstanceOf(SimpleXMLElement::class, $xml);
        $this->assertStringContainsString('<PaymentRequestMessage>', $xml->asXML());
    }

    public function test_pipeline_builds_xml_structure_without_notes_if_empty()
    {
        $paymentDto = $this->getPaymentRequestDtoWithEmptyNotes();
        $pipeline = new Pipeline(app());
        $builder = new BuildPaymentXmlBodyService($pipeline);
        $xml = ($builder->execute($paymentDto))->xml;

        $this->assertNotNull($xml);
        $this->assertInstanceOf(SimpleXMLElement::class, $xml);
        $this->assertStringNotContainsString('<Notes>', $xml->asXML());
    }

    public function test_pipeline_builds_xml_structure_contains_payment_type_if_not_equals_421()
    {
        $paymentDto = $this->getPaymentRequestDtoWithPaymentTypeNotEquals421();
        $pipeline = new Pipeline(app());
        $builder = new BuildPaymentXmlBodyService($pipeline);
        $xml = ($builder->execute($paymentDto))->xml;

        $this->assertNotNull($xml);
        $this->assertInstanceOf(SimpleXMLElement::class, $xml);
        $this->assertStringContainsString('<PaymentType>300</PaymentType>', $xml->asXML());
    }

    public function test_pipeline_builds_xml_structure_contains_charge_details_if_not_equals_SHA()
    {
        $paymentDto = $this->getPaymentRequestDtoWithChargeDetailsNotEqualsSHA();
        $pipeline = new Pipeline(app());
        $builder = new BuildPaymentXmlBodyService($pipeline);
        $xml = ($builder->execute($paymentDto))->xml;

        $this->assertNotNull($xml);
        $this->assertInstanceOf(SimpleXMLElement::class, $xml);
        $this->assertStringContainsString('<ChargeDetails>RB</ChargeDetails>', $xml->asXML());
    }
}
