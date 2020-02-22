<?php


namespace App\Http;

use App\DTO\RepositoryDTO;

class PaginatedListResults
{
    /**
     * @var RepositoryDTO[]|array
     */
    protected array $results;

    /**
     * @var int
     */
    protected int $totalCount;

    /**
     * @var int
     */
    protected int $currentPage;

    /**
     * @var int
     */
    protected int $itemsPerPage;

    /**
     * PaginatedListResults constructor.
     * @param RepositoryDTO[] $results
     * @param int $totalCount
     * @param int $currentPage
     * @param int $itemsPerPage
     */
    public function __construct(array $results, int $totalCount, int $currentPage, int $itemsPerPage)
    {
        $this->results = $results;
        $this->totalCount = $totalCount;
        $this->currentPage = $currentPage;
        $this->itemsPerPage = $itemsPerPage;
    }

    /**
     * @return RepositoryDTO[]|array
     */
    public function getResults(): array
    {
        return $this->results;
    }

    /**
     * @return int
     */
    public function getTotalCount(): int
    {
        return $this->totalCount;
    }

    /**
     * @return int
     */
    public function getCurrentPage(): int
    {
        return $this->currentPage;
    }

    /**
     * @return int
     */
    public function getItemsPerPage(): int
    {
        return $this->itemsPerPage;
    }

    public function merge(PaginatedListResults $paginatedListResults): self
    {
        return new self(
            array_merge($this->results, $paginatedListResults->getResults()),
            $this->totalCount + $paginatedListResults->getTotalCount(),
            $this->currentPage,
            $this->itemsPerPage
        );
    }
}
