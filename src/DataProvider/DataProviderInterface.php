<?php


namespace App\DataProvider;

use App\Http\PaginatedListResults;

/**
 * Interface DataProviderInterface.
 * @package App\DataProvider
 */
interface DataProviderInterface
{
    /**
     * @param string|null $searchQuery
     * @param string|null $sortBy
     * @param int $page
     * @param int $limit
     * @return PaginatedListResults
     */
    public function getList(?string $searchQuery = null, ?string $sortBy = null, int $page = 1, int $limit = 10): PaginatedListResults;
}
