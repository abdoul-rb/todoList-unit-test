<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function isValid()
    {
        try {
            return !empty($this->firstname)
                && !empty($this->lastname)
                && !empty($this->email)
                && filter_var($this->email, FILTER_VALIDATE_EMAIL)
                && $this->validPassword();
        } catch (\Exception $e) {
            echo "Some credentials is invalid : " . $e->getMessage().'<br>';
        }
    }

    private function validPassword()
    {
        return !empty($this->firstname) && Str::length($this->password) >= 8 && Str::length($this->password) <= 40;
    }

    public function todoList()
    {
        return $this->hasOne(TodoList::class);
    }
}
