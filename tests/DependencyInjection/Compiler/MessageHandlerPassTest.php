<?php
declare(strict_types=1);

namespace PcComponentes\DocumentationBundle\Tests\DependencyInjection\Compiler;

use PcComponentes\DocumentationBundle\DependencyInjection\Compiler\MessageHandlerPass;
use PcComponentes\DocumentationBundle\EventWithConverters;
use PcComponentes\DocumentationBundle\Service\ConverterListing;
use PcComponentes\DocumentationBundle\Tests\Mock\ConverterMock;
use PcComponentes\DocumentationBundle\Tests\Mock\EventMock;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

class MessageHandlerPassTest extends TestCase
{
    /** @test */
    public function given_valid_registered_handlers_then_ok()
    {
        $converterMockDefinition = new Definition(ConverterMock::class);
        $converterMockDefinition->addTag('messenger.message_handler', ['mock_bus']);

        $containerBuilder = new ContainerBuilder();
        $containerBuilder->addDefinitions([
            ConverterListing::class => new Definition(ConverterListing::class),
            ConverterMock::class => $converterMockDefinition,
        ]);

        $messageHandlerPass = new MessageHandlerPass();
        $messageHandlerPass->process($containerBuilder);

        $expectedEventWithConverters = EventWithConverters::from(EventMock::messageName, EventMock::class);
        $expectedEventWithConverters->addConverter(ConverterMock::class);

        /** @var ConverterListing $converterListing */
        $converterListing = $containerBuilder->get(ConverterListing::class);
        $this->assertEquals([$expectedEventWithConverters], $converterListing->list());
    }
}
