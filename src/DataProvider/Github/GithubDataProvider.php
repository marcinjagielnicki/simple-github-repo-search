<?php


namespace App\DataProvider\Github;

use App\DataProvider\Github\Api\GithubApiClient;
use App\DataProvider\Github\Factory\GithubRepositoryDTOFactory;
use App\DataProvider\RepositoriesDataProviderInterface;
use App\DTO\RepositoryDTO;
use App\Http\PaginatedListResults;

class GithubDataProvider implements RepositoriesDataProviderInterface
{
    private const SORT_BY = [
        'name' => '', // Github does not provided sort by name (default sort is performed by best match score)
        'fork' => 'forks',
        'star' => 'stars',
    ];

    /**
     * @var GithubApiClient
     */
    private GithubApiClient $apiClient;

    /**
     * @var GithubRepositoryDTOFactory
     */
    private GithubRepositoryDTOFactory $repositoryDTOFactory;

    public function __construct(GithubApiClient $apiClient, GithubRepositoryDTOFactory $repositoryDTOFactory)
    {
        $this->apiClient = $apiClient;
        $this->repositoryDTOFactory = $repositoryDTOFactory;
    }

    /**
     * @inheritDoc
     * @throws \RuntimeException
     */
    public function getList(?string $searchQuery = null, ?string $sortBy = null, int $page = 1, int $limit = 10): PaginatedListResults
    {
        if (empty($searchQuery)) {
            throw new \RuntimeException('Using Github data provider require searchQuery to be filled');
        }
        $query = [
            'q' => $this->prepareQuery($searchQuery) . '+fork:true',
            'page' => $page,
            'per_page' => $limit,
        ];
        if ($sortBy) {
            if (!array_key_exists($sortBy, self::SORT_BY)) {
                throw new \LogicException(sprintf('Sort by %s is not supported by %s', $sortBy, self::class));
            }
            $query['sort'] = self::SORT_BY[$sortBy];
        }
        $data = $this->apiClient->searchRepositories($query);
        $repositories = [];
        foreach ($data['items'] as $repositoryData) {
            $repositoryData['languages'] = $this->loadLanguages($repositoryData['full_name']);
            $repositoryData['forks_list'] = $this->loadForks($repositoryData['full_name']);
            if ($repositoryData['fork']) {
                $forkInfo = $this->getForkedFromData($repositoryData['full_name']);
                if ($forkInfo) {
                    $repositoryData['parent'] = $forkInfo;
                }
            }

            $repositories[] = $this->repositoryDTOFactory->fromArray($repositoryData);
        }
        return new PaginatedListResults($repositories, $data['total_count'], $page, $limit);
    }

    protected function loadLanguages(string $repositoryName): array
    {
        $data = $this->apiClient->getRepositoryInfo($repositoryName, 'languages');
        // small transformation of data from language => number of files to array of languages
        $languages = [];
        foreach ($data as $language => $number) {
            $languages[] = $language;
        }
        return $languages;
    }

    protected function loadForks(string $repositoryName): array
    {
        return $this->apiClient->getRepositoryInfo($repositoryName, 'forks');
    }

    protected function getForkedFromData(string $repositoryName): ?array
    {
        $data = $this->apiClient->getRepositoryInfo($repositoryName);
        return $data['parent'] ?? [];
    }

    protected function prepareQuery(?string $query): ?string
    {
        if (empty($query)) {
            return $query;
        }

        $query = str_replace(['?', ':', '.', ','], '', $query);
        if (strpos($query, '/') !== false) {
            return $query;
        }

        // Default search for organisation
        return 'org:' . $query;
    }

    public function getProviderName(): string
    {
        return 'github';
    }
}
