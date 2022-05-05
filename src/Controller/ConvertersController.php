<?php
declare(strict_types=1);

namespace PcComponentes\DocumentationBundle\Controller;

use PcComponentes\DocumentationBundle\Exception\UnavailableDefinition;
use PcComponentes\DocumentationBundle\Service\ConverterListing;
use PcComponentes\DocumentationBundle\Service\Generator\ConvertersGenerator;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final class ConvertersController
{
    private ConvertersGenerator $generator;
    private ConverterListing $converterListing;

    public function __construct(ConvertersGenerator $generator, ConverterListing $converterListing)
    {
        $this->generator = $generator;
        $this->converterListing = $converterListing;
    }

    public function viewer(): Response
    {
        try {
            return new Response($this->generator->render());
        } catch (UnavailableDefinition $definition) {
            throw new NotFoundHttpException($definition->getMessage(), $definition);
        }
    }

    public function definition(): JsonResponse
    {
        return new JsonResponse($this->converterListing->list(), Response::HTTP_OK, BaseController::$headers);
    }
}
