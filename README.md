Documentation Bundle
====================

The documentation bundle manages the required routes and templates in order to show
documentation both in OpenApi and AsyncApi formats.

Installation
------------

Add the pccomponentes/documentation-bundle package to your require section in the composer.json file.

```bash
$ composer require pccomponentes/documentation-bundle
```

Add the DocumentationBundle to your application's kernel.

```php
<?php
public function registerBundles()
{
    $bundles = [
        // ...
        new PcComponentes\DocumentationBundle\DocumentationBundle(),
        // ...
    ];
    ...
}
```

Depending on your installation, maybe you should add it to the bundles.php file instead.

```php
<?php

return [
    // ...
    PcComponentes\DocumentationBundle\DocumentationBundle::class => ['all' => true],
    // ...
];
```

Usage
-----

Configure the paths to your YAML files in your config.yml (Both keys are optional).

```yaml
documentation:
    openapi: 'docs/openapi.yml'
    asyncapi: 'docs/asyncapi.yml'
```

Enable the paths in your routing.yml file.

```yaml
documentation:
    resource: '@DocumentationBundle/Resources/config/routing.yaml'
    prefix: /docs
```

You can choose a prefix where the documentation will be published.

After this, you should be able to see the Swagger interface at `/openapi` (or `/docs/openapi` if you used the `docs` 
prefix) and the AsyncApi at `/asyncapi`.

Also, you can customize the [SwaggerUI options](https://swagger.io/docs/open-source-tools/swagger-ui/usage/configuration/) 
using the key `swagger_options`, and the [AsyncApi ones](https://github.com/asyncapi/asyncapi-react#web-component)
using `asyncapi_options`, for example:

```yaml
documentation:
    openapi: 'docs/openapi.yml'
    asyncapi: 'docs/asyncapi.yml'
    swagger_options:
        deepLinking: true
        displayOperationId: true
        displayRequestDuration: true
    asyncapi_options:
        schemaFetchOptions: '{"method":"GET","mode":"cors"}'
    
```
