<?php

namespace PcComponentes\DocumentationBundle\Service\Generator;

class AsyncApiGenerator extends Generator
{
    protected function template(): string
    {
        return trim('
        <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>AsyncAPI Specification</title>
</head>
<body>
<script src="https://unpkg.com/@webcomponents/webcomponentsjs@2.5.0/webcomponents-bundle.js"></script>
<script src="https://unpkg.com/@asyncapi/web-component@0.19.0/lib/asyncapi-web-component.js" defer></script>
<asyncapi-component ' . $this->buildComponentParameters() . '>
</asyncapi-component>
</body>
</html>
        ');
    }

    protected function config(): array
    {
        return \array_merge([
            'cssImportPath' => 'https://unpkg.com/@asyncapi/react-component@0.19.0/lib/styles/fiori.css',
            'schemaUrl' => $this->definitionRoute(),
        ], $this->options());
    }

    protected function definitionRoute(): string
    {
        return $this->router->generate('pccomponentes.documentation.asyncapi.definition');
    }

    private function buildComponentParameters(): string
    {
        $parameters = '';

        foreach($this->config() as $parameter => $value) {
            $parameters .= \sprintf('%s=\'%s\' ', $parameter, str_replace('\'', '"', $value));
        }

        return \trim($parameters);
    }
}