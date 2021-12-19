<?php
declare(strict_types=1);

namespace App\Tests\Service;

use App\Entity\Task;
use App\Service\Exception\AlreadyCompletedException;
use App\Service\MarkTaskCompleteService;
use App\Tests\Factory\TaskFactory;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;
use Prophecy\Prophecy\ObjectProphecy;
use Zenstruck\Foundry\Test\Factories;

class MarkTaskCompleteServiceTest extends TestCase
{
    use Factories, ProphecyTrait;

    private ?ObjectProphecy $emP;

    protected function setUp(): void
    {
        $this->emP = $this->prophesize(EntityManagerInterface::class);
    }

    protected function tearDown(): void
    {
        $this->emP = null;
    }

    public function test()
    {
        $task = TaskFactory::createOne()->object();

        $this->emP->persist(Argument::that(function (Task $task) {
            return $task->getCompletedAt() !== null;
        }))->shouldBeCalled();
        $this->emP->flush()->shouldBeCalled();

        $this->getSUT()->markComplete($task);
    }

    public function testAlreadyCompleted()
    {
        $this->expectException(AlreadyCompletedException::class);

        $task = TaskFactory::createOne(['completedAt' => $yesterday = new \DateTimeImmutable('yesterday')])->object();

        $this->emP->persist(Argument::any())->shouldNotBeCalled();
        $this->emP->flush()->shouldNotBeCalled();

        $this->getSUT()->markComplete($task);
    }

    private function getSUT(): MarkTaskCompleteService
    {
        return new MarkTaskCompleteService(
            $this->emP->reveal(),
        );
    }
}
