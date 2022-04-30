<?php
declare(strict_types=1);

// phpcs:disable SlevomatCodingStandard.Functions.RequireMultiLineCall.RequiredMultiLineCall

namespace PcComponentes\DocumentationBundle\Service\Generator;

class OpenApiGenerator extends Generator
{
    protected function template(): string
    {
        return \trim('
        <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>OpenApi Specification</title>
    <link rel="stylesheet" href="//unpkg.com/swagger-ui-dist@4.5.0/swagger-ui.css" />
</head>
<body>
<div style="width: 100%%; background-color: #eeeeee; padding: 0.5em 0 0.1em 0.3em; font-family: Tahoma, Verdana, sans-serif	">
    <p><a href="' . $this->router->generate('pccomponentes.documentation.home') . '">< Go back to documentation home</a></p>
</div>
<div id="swagger-ui"></div>
<script src="https://unpkg.com/swagger-ui-dist@4.5.0/swagger-ui-bundle.js" crossorigin></script>
<script>
window.onload = () => {
    window.ui = SwaggerUIBundle(' . \json_encode($this->config(), \JSON_PRETTY_PRINT) . ')
};
</script>
</body>
</html>');
    }

    protected function config(): array
    {
        return \array_merge([
            'dom_id' => '#swagger-ui',
            'url' => $this->definitionRoute(),
        ], $this->options());
    }

    protected function definitionRoute(): string
    {
        return $this->router->generate('pccomponentes.documentation.openapi.definition');
    }
}
