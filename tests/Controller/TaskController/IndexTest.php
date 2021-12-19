<?php
declare(strict_types=1);

namespace App\Tests\Controller\TaskController;

use App\Tests\Factory\TaskFactory;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Zenstruck\Foundry\Test\Factories;

class IndexTest extends WebTestCase
{
    use Factories;

    public function test()
    {
        $client = static::createClient();

        // 1件未完了タスクを作る
        TaskFactory::createOne(['completedAt' => null]);
        // 2件完了済タスクを作る
        TaskFactory::createMany(2, ['completedAt' => new \DateTimeImmutable('yesterday')]);

        $crawler = $client->request('GET', '/task');

        $this->assertResponseIsSuccessful();
        $this->assertTrue($crawler->filter('title')->text() === '未完了のタスク');
        $this->assertEquals(1, $crawler->filter('li')->count(), '未完了の1件のみ');
    }
}
