<?php
declare(strict_types=1);

// phpcs:disable SlevomatCodingStandard.Files.LineLength.LineTooLong
// phpcs:disable Generic.Files.LineLength.TooLong

namespace PcComponentes\DocumentationBundle\Controller;

use PcComponentes\DocumentationBundle\Service\Generator\AsyncApiGenerator;
use PcComponentes\DocumentationBundle\Service\Generator\ConvertersGenerator;
use PcComponentes\DocumentationBundle\Service\Generator\OpenApiGenerator;
use PcComponentes\DocumentationBundle\Service\LinkListing;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;

final class HomeController
{
    private RouterInterface $router;
    private ConvertersGenerator $convertersGenerator;
    private AsyncApiGenerator $asyncApiGenerator;
    private OpenApiGenerator $openApiGenerator;
    private LinkListing $linkListing;

    public function __construct(
        RouterInterface $router,
        ConvertersGenerator $convertersGenerator,
        AsyncApiGenerator $asyncApiGenerator,
        OpenApiGenerator $openApiGenerator,
        LinkListing $linkListing
    ) {
        $this->router = $router;
        $this->convertersGenerator = $convertersGenerator;
        $this->asyncApiGenerator = $asyncApiGenerator;
        $this->openApiGenerator = $openApiGenerator;
        $this->linkListing = $linkListing;
    }

    public function home(): Response
    {
        return new Response($this->html());
    }

    private function html(): string
    {
        $html = \trim('
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>Documentation Home</title>
</head>

<body>

<div class="col-lg-8 mx-auto p-3 py-md-5"> 
    <main>
        <div class="jumbotron">
            <span class="w-25">
                <svg width="20%%" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 138 48"><path fill="#FF6000" d="M69.51 27.57h18.4v6.13h-18.4v-6.13z"/><path fill="#575757" d="M90.41 7.15h-36.23v26.55h8.66v-10.42h27.58c2.56 0 4.65-2.11 4.65-4.69v-6.78c0-2.57-2.09-4.66-4.66-4.66zm-3.15 8.7c0 1.28-1.04 2.32-2.32 2.32h-22.16v-5.92h22.18c1.27 0 2.32 1.05 2.32 2.32v1.28h-.02z"/><path fill="#575757" d="M137.98 24.71h-8.54v3.33h-21.47c-1.27 0-2.32-1.05-2.32-2.32v-10.59c0-1.28 1.04-2.32 2.32-2.32h21.47v3.24h8.54v-3.33c-.23-3.09-2.83-5.56-5.96-5.56h-28.95c-3.26 0-5.96 2.7-5.96 6v14.54c0 3.3 2.68 6 5.96 6h28.97c3.15 0 5.77-2.51 5.96-5.66v-3.33h-.02z"/><path fill="#999" d="M59.61 40.53v-.43c0-.25-.04-.42-.08-.55-.06-.13-.14-.23-.3-.28-.12-.06-.32-.11-.55-.13-.24-.02-.55-.02-.89-.02-.4 0-.75.02-.99.06-.26.04-.47.13-.59.26-.14.13-.24.32-.28.55-.04.25-.08.55-.08.95v1.78c0 .4.02.72.06.97s.12.46.26.59c.12.13.32.23.59.28.24.06.61.08 1.03.08.32 0 .61-.02.85-.04s.45-.06.59-.13c.16-.08.28-.19.34-.36.08-.15.12-.38.12-.66v-.44h1.64v.53c.02.61-.06 1.08-.24 1.38-.18.32-.4.55-.73.7-.3.15-.69.23-1.13.26l-1.46.08c-.75.02-1.36-.02-1.82-.11-.45-.11-.83-.28-1.07-.55-.26-.26-.43-.59-.53-1s-.14-.91-.16-1.5v-1.86c0-.64.08-1.16.2-1.57.14-.4.34-.72.65-.97.28-.25.67-.4 1.11-.47.47-.08.99-.13 1.62-.13.53 0 1.01.02 1.42.04.43.02.77.11 1.07.25.28.15.53.38.69.68.16.3.26.76.3 1.33v.44h-1.64v-.01zM66.48 37.88c.44.06.82.19 1.12.4.3.19.52.49.68.89.14.38.22.91.22 1.56v2.17c0 .65-.06 1.16-.2 1.56-.14.4-.34.7-.64.93s-.66.38-1.12.46-1 .11-1.63.11c-.66 0-1.2-.04-1.65-.11s-.82-.23-1.1-.44-.48-.53-.62-.93c-.12-.4-.2-.93-.2-1.6v-2.17c0-.63.06-1.14.18-1.52.12-.38.32-.68.6-.89s.64-.34 1.1-.42 1.02-.1 1.67-.1c.61.01 1.15.04 1.59.1zm-2.62 1.31c-.26.06-.44.13-.58.25-.14.13-.22.28-.26.49-.04.21-.06.47-.08.8v2.17c0 .4.02.7.08.95.06.23.16.42.3.53.14.11.34.19.6.23.26.04.58.06.98.06.36 0 .68-.02.94-.06.26-.04.46-.11.62-.23.16-.13.28-.3.34-.53.06-.25.1-.55.1-.93v-2.17c0-.38-.02-.67-.1-.89-.08-.21-.18-.38-.34-.47-.16-.11-.36-.17-.62-.21-.26-.02-.56-.04-.92-.04-.46-.02-.8 0-1.06.05zM70.93 45.96h-1.42v-8.17h2.43l2.15 6.07h.04l2.11-6.07h2.48v8.17h-1.44v-6.88l-2.48 6.88h-1.34l-2.5-6.84v6.84h-.03zM79.75 37.79h3.39c.51 0 .94.04 1.29.11.35.08.64.23.83.44.22.21.36.49.45.85s.14.84.14 1.41c0 .59-.05 1.04-.14 1.41s-.25.63-.47.82c-.22.19-.49.32-.85.4-.35.06-.76.1-1.27.1h-1.92v2.64h-1.47v-8.17l.02-.01zm3.39 4.18c.27 0 .47-.02.64-.06s.29-.11.38-.21c.09-.1.14-.25.18-.42.04-.17.05-.4.05-.68s-.02-.53-.04-.72c-.02-.19-.09-.34-.18-.46-.09-.11-.22-.19-.38-.23-.18-.04-.4-.06-.65-.06h-1.92v2.85h1.92v-.01zm8.9-4.09c.44.06.82.19 1.12.4.3.19.52.49.66.89.16.38.22.91.22 1.56v2.17c0 .65-.06 1.16-.2 1.56s-.36.7-.64.93c-.3.23-.66.38-1.12.46s-1 .11-1.64.11c-.66 0-1.2-.04-1.66-.11s-.82-.23-1.1-.44c-.28-.21-.48-.53-.6-.93s-.18-.93-.18-1.6v-2.17c0-.63.06-1.14.18-1.52s.32-.68.6-.89c.28-.21.64-.34 1.1-.42s1.02-.1 1.68-.1c.6.01 1.12.04 1.58.1zm-2.63 1.31c-.26.06-.44.13-.58.25-.14.13-.22.28-.26.49-.04.21-.06.47-.08.8v2.17c0 .4.02.7.08.95.06.23.14.42.28.53.14.11.34.19.6.23.26.04.58.06 1 .06.36 0 .68-.02.92-.06.26-.04.46-.11.62-.23.16-.13.26-.3.34-.53.08-.25.1-.55.1-.93v-2.17c0-.38-.02-.67-.08-.89-.08-.21-.2-.38-.34-.47-.16-.11-.36-.17-.62-.21-.26-.02-.56-.04-.92-.04-.46-.02-.8 0-1.06.05zM96.48 45.96h-1.41v-8.17h2.46l3.3 6.82v-6.82h1.39v8.17h-2.46l-3.3-6.82v6.82h.02zm9.19-4.8h3.48v1.29h-3.46v2.16h3.69v1.35h-5.11v-8.17h5.11v1.33h-3.69v2.05l-.02-.01zm6.14 4.8h-1.41v-8.17h2.43l3.31 6.82v-6.82h1.41v8.17h-2.47l-3.29-6.82v6.82h.02zm10.59 0h-1.51v-6.82h-2.31v-1.35h6.13v1.35h-2.31v6.82zm4.76-4.8h3.46v1.29h-3.46v2.16h3.69v1.35h-5.11v-8.17h5.11v1.35h-3.69v2.02zm6.17 2.17v.38c0 .23.02.4.07.55.05.13.14.23.27.29s.3.11.54.13c.21.02.5.02.82.02.34 0 .59-.02.79-.06s.36-.1.45-.19c.11-.1.18-.21.21-.36.04-.15.05-.34.05-.57 0-.29-.04-.49-.11-.65-.07-.13-.18-.23-.32-.29s-.32-.1-.54-.1l-.73-.02-1.14-.1c-.36-.04-.66-.11-.93-.27-.27-.13-.46-.38-.63-.69-.16-.31-.23-.76-.23-1.35 0-.55.07-.97.23-1.29.16-.31.38-.53.64-.69.29-.15.61-.23.98-.27.38-.02.79-.04 1.25-.04.39 0 .75.02 1.09.04.34.04.64.11.88.25.27.13.46.36.61.65.14.31.23.71.23 1.24v.25h-1.45v-.25c0-.21-.02-.38-.07-.51-.04-.11-.12-.21-.23-.27-.11-.06-.25-.1-.41-.11-.16-.02-.38-.02-.64-.02-.36 0-.64.02-.86.04-.21.02-.39.08-.5.15-.11.08-.2.17-.23.31-.04.13-.05.31-.05.53 0 .25.02.44.05.57s.11.25.23.31c.12.08.29.13.5.15.21.02.52.06.88.08.59.04 1.07.08 1.45.13.38.06.68.17.91.32.21.15.38.38.46.67.09.29.14.69.14 1.2 0 .57-.07 1.01-.2 1.33s-.3.57-.55.74c-.25.17-.55.29-.93.32-.36.04-.79.06-1.27.06-.41 0-.8-.02-1.2-.04-.38-.02-.71-.1-1.02-.23-.29-.13-.52-.36-.7-.67-.18-.31-.27-.74-.27-1.33v-.38h1.47l.01.04z"/><linearGradient id="a" gradientUnits="userSpaceOnUse" x1="-224.768" y1="317.768" x2="-223.768" y2="317.768" gradientTransform="matrix(43.956 0 0 -40.851 9879.809 13008.805)"><stop offset="0" stop-color="#FF6000"/><stop offset=".3" stop-color="#FF6000"/><stop offset="1" stop-color="#FFA900"/></linearGradient><path fill="url(#a)" d="M43.95 11.62v24.46c.3 6.53-8.35 10.7-14.42 11.73-4.2.72-8.17-.8-10.66-2.09l-17.5-9.15c-.46-.3-1.37-.83-1.37-2.69v-24.91c0-3.38 3.4-1.2 5.97-.21l13.21 5.54c3.06 1.33 7.52 3.07 11.06 2.73 7.72-.7 13.71-5.41 13.71-5.41z"/><linearGradient id="b" gradientUnits="userSpaceOnUse" x1="-217.5" y1="302.061" x2="-216.5" y2="302.061" gradientTransform="matrix(18.4 0 0 -12.255 4021.336 3708.01)"><stop offset="0" stop-color="#FF6000"/><stop offset=".3" stop-color="#FF6000"/><stop offset="1" stop-color="#FFA900"/></linearGradient><path fill="url(#b)" d="M27.62 12.1c2.57.62 6.28-.62 9.63-2.9.95-.56.87-1.96-1.45-2.97-3.98-1.73-10.75-4.69-10.75-4.69-2.98-1.3-5.63-2.9-5.63.45v6.84s6.53 2.86 8.2 3.27z"/></svg>
            </span>
            
            <h1 class="display-4">Documentation</h1>
            <p class="lead">Welcome to our documentation site :)</p>
            <hr class="my-4">
            <p class="lead">%s</p>
        </div>
        %s
    </main>
</div>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>
        ');

        return \sprintf($html, $this->buildButtons(), $this->buildLinks());
    }

    private function buildButtons(): string
    {
        $buttons = '';

        if ($this->openApiGenerator->isReady()) {
            $buttons .= \sprintf(
                '<a class="btn btn-primary" href="%s" role="button">OpenApi</a> ',
                $this->router->generate('pccomponentes.documentation.openapi.viewer'),
            );
        }
        
        if ($this->asyncApiGenerator->isReady()) {
            $buttons .= \sprintf(
                '<a class="btn btn-primary" href="%s" role="button">AsyncApi</a> ',
                $this->router->generate('pccomponentes.documentation.asyncapi.viewer'),
            );
        }

        if ($this->convertersGenerator->isReady()) {
            $buttons .= \sprintf(
                '<a class="btn btn-primary" href="%s" role="button">Converters</a> ',
                $this->router->generate('pccomponentes.documentation.converters.viewer'),
            );
        }

        return $buttons;
    }

    private function buildLinks(): string
    {
        if (false === $this->linkListing->hasLinks()) {
            return '';
        }

        $links = '';

        foreach ($this->linkListing->list() as $link) {
            $links .= \sprintf(
                '<li><a href="%s" target="_blank">%s</a>. <small>%s</small></li>',
                $link[LinkListing::KEY_URL],
                $link[LinkListing::KEY_DESCRIPTION],
                $link[LinkListing::KEY_TITLE],
            );
        }

        return \sprintf(\trim('
        <row>
            <col>
                <h2>Other links</h2>
                <ul>%s</ul>
            </col>
        </row>
        '), $links);
    }
}
