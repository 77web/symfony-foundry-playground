<?php
declare(strict_types=1);

namespace App\Tests\Controller\TaskController;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CompletedTest extends WebTestCase
{
    public function test()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/task/completed');

        $this->assertResponseIsSuccessful();
        $this->assertTrue($crawler->filter('title')->text() === '完了したタスク');
    }
}
