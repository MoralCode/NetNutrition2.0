<?php

namespace Unit;

use App\Role;
use App\User;
use TestCase;
use function random_int;

class UserControllerTest extends TestCase
{
    /** @var User */
    protected $user;

    public function setUp()
    {
        parent::setUp();

        $this->user = factory(User::class)->create([
            'password' => 'testing123',
            'role_id' => Role::ADMIN,
        ]);

        $this->be($this->user);
    }

    public function tearDown()
    {
        $this->user->refresh()->forceDelete();

        parent::tearDown();
    }

    public function testIndex()
    {
        $this->get('/user')
            ->assertResponseOk();
    }

    public function testShow()
    {
        $this->get("/user/{$this->user->refresh()->id}")
            ->assertResponseOk();

        $this->get('/user/0')
            ->assertResponseStatus(404);
    }

    public function testUpdate()
    {
        $newNetId = 'testing' . random_int(0, 1000);
        $this->post("/user/update/{$this->user->refresh()->id}", [
            'net_id' => $newNetId,
            'role_id' => Role::ADMIN,
        ])->assertResponseOk();

        $this->assertEquals($newNetId, $this->user->refresh()->net_id);
    }

    public function testDestroy()
    {
        $tmpUser = factory(User::class)->create([
            'role_id' => Role::CHEF,
        ])->id;

        $this->post("/user/destroy/{$tmpUser}")
            ->assertResponseOk();

        $this->assertNull(User::find($tmpUser));
    }
}