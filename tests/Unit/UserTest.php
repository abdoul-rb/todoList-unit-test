<?php

namespace Tests\Unit;

use App\Models\User;
use Carbon\Carbon;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    private $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user =  User::create([
            'firstname' => 'Bah',
            'lastname' => 'Rahim',
            'birthday' => Carbon::now()->subYears(20),
            'email' => 'rahim.bah@gmail.com',
            'password' => 'password',
        ]);
    }

    /**
     * @test
     * @return void
     */
    public function userIsValid()
    {
        $this->assertTrue($this->user->isValid());
    }

    /**
     * @test
     */
    public function notValidFirstname()
    {
        $this->user->firstname = '';
        $this->assertFalse($this->user->isValid());
    }

    /**
     * @test
     */
    public function notValidLastname()
    {
        $this->user->lasstname = '';
        $this->assertFalse($this->user->isValid());
    }

    /**
     * @test
     */
    public function notValidEmail()
    {
        $this->user->email = 'email';
        $this->assertFalse($this->user->isValid());
    }

    /**
     * @test
     */
    public function notValidToYoungerUser()
    {
        $this->user->birthday = Carbon::now()->subDecade();
        $this->assertFalse($this->user->isValid());
    }

    /**
     * @test
     */
    public function notValidBirthToFuture()
    {
        $this->user->birthday = Carbon::now()->addDecade();
        $this->assertFalse($this->user->isValid());
    }
}
