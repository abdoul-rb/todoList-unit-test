<?php

namespace Tests\Unit;

use App\Models\Item;
use App\Models\TodoList;
use App\Models\User;
use Carbon\Carbon;
use PHPUnit\Framework\TestCase;

class TodoListTest extends TestCase
{
    private $item;
    private $user;
    private $todoList;

    protected function setUp(): void
    {
        parent::setUp();

        $this->item = new Item([
            'name' => 'Unit testing in Laravel',
            'content' => 'Implementer des test unitaires avec des Mockups en Laravel',
            'created_at' => Carbon::now()->subHour()
        ]);

        $this->user = new User([
            'firstname' => 'Bah',
            'lastname' => 'Rahim',
            'email' => 'rahim.bah@gmail.com',
            'password' => 'password',
            'birthday' => Carbon::now()->subDecades(3)->subMonths(7)->subDays(24)->toDateString()
        ]);

        $this->todoList = $this->getMockBuilder(TodoList::class)
            ->onlyMethods(['actualItemsCount', 'getLastItem'])
            ->getMock();

        $this->todoList->user = $this->user;
    }

    /**
     * @test
     */
    public function canAddItemNominalTest()
    {
        $this->todoList->expects($this->once())->method('actualItemsCount')->willReturn(1);
        $this->todoList->expects($this->any())->method('getLastItem')->willReturn(1);

        $canAddItem = $this->todoList->canAddItem($this->item);
        $this->assertNotNull($canAddItem);
        $this->assertEquals('Unit testing in Laravel', $canAddItem->name);
    }

    /**
     * @test
     */
    public function cannotAddItemInMaxNumberReachedTest()
    {
        $this->todoList->expects($this->any())->method('actualItemsCount')->willReturn(10);
        $this->expectException('Exception');
        $this->expectExceptionMessage('La TodoList contient déjà trop de tâches !');
    }


}
