<?php

namespace App\Tests\DataProvider\Github\Factory;

use App\DataProvider\Github\Factory\GithubRepositoryDTOFactory;
use PHPUnit\Framework\TestCase;

class GithubRepositoryDTOFactoryTest extends TestCase
{
    public function testFromArray(): void
    {
        $data = [
            'name' => 'test',
            'full_name' => 'app/test',
            'html_url' => 'https://test.app',
            'parent' => [
                'name' => 'test2',
                'full_name' => 'app/test2',
                'html_url' => 'https://test.app/2',
            ],
            'languages' => ['PHP', 'JavaScript'],
            'forks_list' => [
                [
                    'name' => 'test',
                    'full_name' => 'app/test',
                    'html_url' => 'https://test.app',
                ],
            ],
        ];

        $factory = new GithubRepositoryDTOFactory();

        $dto = $factory->fromArray($data);
        $this->assertEquals('test', $dto->getName());
        $this->assertNotEmpty($dto->getForkOf());
        $this->assertNotEmpty($dto->getLanguages());
        $this->assertCount(2, $dto->getLanguages());
        $languages = $dto->getLanguages();
        $this->assertEquals('PHP', $languages[0]->getName());
        $this->assertCount(1, $dto->getForks());
    }
}
