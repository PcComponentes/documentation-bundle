<?php declare(strict_types=1);

namespace PcComponentes\DocumentationBundle\Controller;

use PcComponentes\DocumentationBundle\Exception\UnavailableDefinition;
use PcComponentes\DocumentationBundle\Service\Generator\ConvertersGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final class ConvertersController
{
    private ConvertersGenerator $generator;

    public function __construct(ConvertersGenerator $generator)
    {
        $this->generator = $generator;
    }

    public function viewer(): Response
    {
        try {
            return new Response($this->generator->render());
        } catch (UnavailableDefinition $definition) {
            throw new NotFoundHttpException($definition->getMessage(), $definition);
        }
    }
}
