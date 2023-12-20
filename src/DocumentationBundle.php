<?php
declare(strict_types=1);

namespace PcComponentes\DocumentationBundle;

use PcComponentes\DocumentationBundle\DependencyInjection\Compiler\MessageHandlerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

final class DocumentationBundle extends Bundle
{
    public function build(ContainerBuilder $container): void
    {
        $container->addCompilerPass(new MessageHandlerPass());
    }
}
