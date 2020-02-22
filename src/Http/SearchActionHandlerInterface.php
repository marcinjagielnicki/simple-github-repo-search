<?php


namespace App\Http;

interface SearchActionHandlerInterface
{
    public function handleSearch(array $data, bool $useAllProviders = true, ?string $useProvider = null): PaginatedListResults;
}
