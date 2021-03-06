<?php
declare(strict_types=1);

namespace PcComponentes\DocumentationBundle\Controller;

use PcComponentes\DocumentationBundle\Exception\UnavailableDefinition;
use PcComponentes\DocumentationBundle\Service\Generator\Generator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

abstract class BaseController
{
    private Generator $generator;
    public static array $headers = [
        'Access-Control-Allow-Origin' => '*',
        'Access-Control-Allow-Methods' => 'GET',
        'Access-Control-Allow-Headers' => 'Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method',
    ];

    public function __construct(Generator $generator)
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

    public function definition(): Response
    {
        try {
            return new Response($this->generator->definition(), Response::HTTP_OK, BaseController::$headers);
        } catch (UnavailableDefinition $definition) {
            throw new NotFoundHttpException($definition->getMessage(), $definition);
        }
    }
}
