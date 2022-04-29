<?php
declare(strict_types=1);

namespace PcComponentes\DocumentationBundle\Tests\Service;

use PcComponentes\DocumentationBundle\EventWithConverters;
use PcComponentes\DocumentationBundle\Service\ConverterListing;
use PHPUnit\Framework\TestCase;

final class ConverterListingTest extends TestCase
{
    private ConverterListing $converterListing;

    public function setUp(): void
    {
        $this->converterListing = new ConverterListing();

        parent::setUp();
    }

    /** @test */
    public function given_added_new_event_then_ok()
    {
        $this->converterListing->add(
            'event_name',
            '\\PcComponentes\\Event\\EventName',
            '\\PcComponentes\\Converter\\ConverterName'
        );

        $this->assertCount(1, $this->converterListing->list());
        $this->assertInstanceOf(EventWithConverters::class, $this->converterListing->list()[0]);
        $this->assertEquals(
            '{"name":"event_name","className":"\\\\PcComponentes\\\\Event\\\\EventName","converters":["\\\\PcComponentes\\\\Converter\\\\ConverterName"]}',
            \json_encode($this->converterListing->list()[0]));
    }

    /** @test */
    public function given_added_new_event_having_already_previous_one_then_ok()
    {
        $this->converterListing->add(
            'event_name',
            '\\PcComponentes\\Event\\EventName',
            '\\PcComponentes\\Converter\\ConverterName'
        );

        $this->converterListing->add(
            'event_name',
            '\\PcComponentes\\Event\\EventName',
            '\\PcComponentes\\Converter\\AnotherConverterName'
        );

        $this->assertCount(1, $this->converterListing->list());
        $this->assertInstanceOf(EventWithConverters::class, $this->converterListing->list()[0]);
        $this->assertEquals(
            '{"name":"event_name","className":"\\\\PcComponentes\\\\Event\\\\EventName","converters":["\\\\PcComponentes\\\\Converter\\\\ConverterName","\\\\PcComponentes\\\\Converter\\\\AnotherConverterName"]}',
            \json_encode($this->converterListing->list()[0]));
    }
}
