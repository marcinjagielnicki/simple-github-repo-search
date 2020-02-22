<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SearchRepositoriesControllerTest extends WebTestCase
{
    public function testSearchAction(): void
    {
        $client = static::createClient();
        $client->xmlHttpRequest(
            'POST',
            '/api/search',
            [],
            [],
            [],
            json_encode(
                [
                    'query' => 'sensiolabs',
                    'sort' => 'fork',
                    'page' => 2
                ]
            )
        );
        $this->assertResponseStatusCodeSame(200);
        $responseData = json_decode($client->getResponse()->getContent(), true);
        $this->assertNotEmpty($responseData);
        $this->assertArrayHasKey('results', $responseData);
        $this->assertArrayHasKey('totalCount', $responseData);
        $this->assertTrue($responseData['totalCount'] > 0);
        $this->assertEquals(2, $responseData['currentPage']);

        $results = $responseData['results'];
        $this->assertTrue(count($results) > 0);

        $singleItem = $results[0];
        $this->assertArrayHasKey('name', $singleItem);
        $this->assertNotEmpty($singleItem['name']);
        $this->assertNotEmpty($singleItem['fullName']);
        $this->assertNotEmpty($singleItem['url']);
    }
}
