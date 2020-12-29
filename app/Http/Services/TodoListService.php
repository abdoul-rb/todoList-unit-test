<?php

namespace App\Http\Services;

use App\Models\Item;
use App\Models\TodoList;
use App\Models\User;

/**
 * Déporter la logique hors du controller pour l'ajout des Item d'un User dans la TodoList
 * Class TodoListService
 * @package App\Http\Services
 */
class TodoListService
{
    public function createTodoList(User $user, string $name, ?string $content)
    {
        if(is_null($user) || !$user->isValid()) {
            return false;
        } elseif(is_null($user->todoList)) {
            return false;
        }

        $todoList = TodoList::make([
            'name' => $name,
            '$description' => $content,
        ]);

        $user->todoList()->save($todoList);

        return true;
    }

    public function addItem(User $user, string $name, ?string $content)
    {
        if(is_null($user) || !$user->isValid()) {
            return false;
        } elseif(is_null($user->todoList)) {
            return false;
        }

        foreach ($user->todoList->items as $item) {
            if($item->name = $name) {
                return false;
            }
        }

        $item = Item::make([
            'name' => $name,
            '$description' => $content,
        ]);

        if (!$user->todoList->canAddItem($item)) {
            return false;
        }

        $user->todoList()->save($item);

        return true;
    }
}
