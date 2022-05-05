<?php
declare(strict_types=1);

namespace PcComponentes\DocumentationBundle\Service;

class LinkListing
{
    public const KEY_TITLE = 'title';
    public const KEY_DESCRIPTION = 'description';
    public const KEY_URL = 'url';

    protected array $links = [];

    public function set(array $links): void
    {
        $this->links = $links;
    }

    /** @return array<array> */
    public function list(): array
    {
        return $this->links;
    }

    public function hasLinks(): bool
    {
        return 0 !== \count($this->links);
    }
}
