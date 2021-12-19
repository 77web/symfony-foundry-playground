<?php
declare(strict_types=1);

namespace App\Tests\Controller\TaskController;

use App\Tests\Factory\TaskFactory;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Zenstruck\Foundry\Test\Factories;

class CompletedTest extends WebTestCase
{
    use Factories;

    public function test()
    {
        $client = static::createClient();

        // 1件未完了タスクを作る
        TaskFactory::createOne(['completedAt' => null]);
        // 2件完了済タスクを作る
        TaskFactory::createMany(2, ['completedAt' => new \DateTimeImmutable('yesterday')]);

        $crawler = $client->request('GET', '/task/completed');

        $this->assertResponseIsSuccessful();
        $this->assertTrue($crawler->filter('title')->text() === '完了したタスク');
        $this->assertTrue($crawler->filter('li')->count() === 2, '完了済の2件のみ');
    }
}
