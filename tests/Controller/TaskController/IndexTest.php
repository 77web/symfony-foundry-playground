<?php
declare(strict_types=1);

namespace App\Tests\Controller\TaskController;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class IndexTest extends WebTestCase
{
    public function test()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/task');

        $this->assertResponseIsSuccessful();
        $this->assertTrue($crawler->filter('title')->text() === '未完了のタスク');
    }
}
