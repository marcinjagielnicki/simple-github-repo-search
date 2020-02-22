<?php


namespace App\DataProvider\Github\Api;

use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

class GithubApiClient
{
    private const API_URL = 'https://api.github.com/';

    /**
     * @var Client
     */
    private Client $client;

    public function __construct(string $username, string $password)
    {
        $this->client = new Client(
            [
                'base_uri' => self::API_URL,
                'auth' => [$username, $password]
            ]
        );
    }

    public function searchRepositories(array $query): array
    {
        $defaultQuery = [
            'per_page' => 10,
            'page' => 1
        ];
        $response = $this->client->get('search/repositories', ['query' => $this->prepareQueryString(array_merge($defaultQuery, $query))]);
        return $this->transformResponseToArray($response);
    }

    public function getRepositoryInfo(string $repositoryName, ?string $object = null): array
    {
        if ($object) {
            $response = $this->client->get(sprintf('repos/%s/%s', $repositoryName, $object));
        } else {
            $response = $this->client->get(sprintf('repos/%s', $repositoryName));
        }
        return $this->transformResponseToArray($response);
    }

    protected function transformResponseToArray(ResponseInterface $response): array
    {
        $body = (string) $response->getBody();
        return json_decode($body, true);
    }

    protected function prepareQueryString(array $data): string
    {
        $postUrl = '';
        foreach ($data as $key => $value) {
            $postUrl .= $key . '=' . $value . '&';
        }
        return rtrim($postUrl, '&');
    }
}
