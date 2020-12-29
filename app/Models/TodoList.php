<?php

namespace App\Models;

use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TodoList extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        // return $this->hasMany(Item::class);
        return $this->hasMany(Item::class)->orderBy('created_at', 'desc');
    }

    public function isValid()
    {
        return !empty($this->name)
                && strlen($this->name) <= 255
                && (is_null($this->content) || strlen($this->content) <= 255);
    }

    /**
     * @param Item $item
     * @return Item
     * @throws Exception
     */
    public function canAddItem(Item $item)
    {
        if (is_null($item) && !$item->isValid()) {
            throw new Exception('Tâche invalide ou vide !');
        }

        if (is_null($this->user) && !$this->user->isValid()) {
            throw new Exception('User invalide !');
        }

        if ($this->actualItemsCount() >= 10) {
            throw new Exception('La TodoList contient déjà trop de tâches !');
        }

        $lastItem = $this->getLastItem();
        if (!is_null($this->getLastItem()) && Carbon::now()->subMinutes(30)->isBefore($lastItem->created_at)) {
            throw new Exception('Attendez 30 minutes !');
        }

        return $item;
    }

    protected function getLastItem()
    {
        return $this->items->first();
    }

    protected function actualItemsCount()
    {
        return sizeof($this->items()->get());
    }
}
