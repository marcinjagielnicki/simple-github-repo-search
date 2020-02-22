<?php


namespace App\Http;

use App\DataProvider\RepositoriesDataProvider;

class SearchActionHandler
{
    const PER_PAGE_RESULTS = 6;

    /**
     * @var RepositoriesDataProvider
     */
    private RepositoriesDataProvider $repositoriesDataProvider;

    /**
     * @var string
     */
    private string $defaultRepositoriesProvider;

    public function __construct(RepositoriesDataProvider $repositoriesDataProvider, string $defaultRepositoriesProvider)
    {
        $this->repositoriesDataProvider = $repositoriesDataProvider;
        $this->defaultRepositoriesProvider = $defaultRepositoriesProvider;
    }

    /**
     * @param array $data
     * @param bool $useAllProviders
     * @param string|null $useProvider
     * @return PaginatedListResults
     */
    public function handleSearch(array $data, bool $useAllProviders = true, ?string $useProvider = null): PaginatedListResults
    {
        $dataProviders = [];
        if ($useAllProviders) {
            $dataProviders = $this->repositoriesDataProvider->getProviders();
        } else {
            $dataProviders[] = $this->repositoriesDataProvider->getProviderByName($useProvider ?? $this->defaultRepositoriesProvider);
        }
        $results = new PaginatedListResults([], 0, $data['page'] ?? 1, self::PER_PAGE_RESULTS);
        foreach ($dataProviders as $provider) {
            $results = $results->merge($provider->getList($data['query'], $data['sort'] ?? 'name', $data['page'] ?? 1, self::PER_PAGE_RESULTS));
        }

        return $results;
    }
}
