<?php

namespace App\Tests\DataProvider\Github;

use App\DataProvider\Github\Api\GithubApiClient;
use App\DataProvider\Github\Factory\GithubRepositoryDTOFactory;
use App\DataProvider\Github\GithubDataProvider;
use App\Http\PaginatedListResults;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class GithubDataProviderTest extends TestCase
{
    /**
     * @var GithubDataProvider
     */
    private GithubDataProvider $githubDataProvider;

    public function setUp(): void
    {
        $factory = new GithubRepositoryDTOFactory();
        /** @var GithubApiClient|MockObject $apiClient */
        $apiClient = $this->createMock(GithubApiClient::class);
        $apiClient->method('searchRepositories')->withAnyParameters()->willReturn(
            [
                'total_count' => 1,
                'items' => [
                    [
                        'name' => 'test',
                        'full_name' => 'app/test',
                        'html_url' => 'https://test.app',
                        'fork' => false,
                        'parent' => [
                            'name' => 'test2',
                            'full_name' => 'app/test2',
                            'html_url' => 'https://test.app/2',
                        ]
                    ],
                ]
            ]
        );

        $valueMap = [
            [
                'app/test',
                'languages',
                [
                    'JavaScript' => 132,
                    'PHP' => 10
                ],
            ],
            [
                'app/test',
                'forks',
                [
                    [
                        'name' => 'test',
                        'full_name' => 'app_fork/test',
                        'html_url' => 'https://test.app',
                    ],
                ],
            ],
        ];
        $apiClient->method('getRepositoryInfo')->will($this->returnValueMap($valueMap));
        $this->githubDataProvider = new GithubDataProvider($apiClient, $factory);
    }

    public function testGetList(): void
    {
        $data = $this->githubDataProvider->getList('test');
        $this->assertTrue($data instanceof PaginatedListResults);
        $this->assertCount(1, $data->getResults());
        $this->assertEquals(1, $data->getTotalCount());

        $results = $data->getResults();
        $object = $results[0];

        $this->assertEquals('test', $object->getName());
        $this->assertEquals('app/test', $object->getFullName());
        $this->assertEquals('https://test.app', $object->getUrl());
        $this->assertNotEmpty($object->getForkOf());

        $fork = $object->getForkOf();
        $this->assertEquals('test2', $fork->getName());


        $languages = $object->getLanguages();
        $this->assertCount(2, $languages);

        $forks = $object->getForks();
        $this->assertCount(1, $forks);
    }
}
