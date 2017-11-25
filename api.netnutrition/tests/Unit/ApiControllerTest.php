<?php

namespace Unit;

use App\User;
use TestCase;

class ApiControllerTest extends TestCase
{
    /** @var User */
    protected $user;

    public function setUp()
    {
        parent::setUp();

        $this->user = factory(User::class)->create([
            'net_id' => 'testing123',
            'password' => 'testing123',
        ]);
    }

    public function tearDown()
    {
        $this->user->delete();

        parent::tearDown();
    }

    public function testLogin()
    {
        $this->post('/login', [
            'net_id' => 'testing123',
            'password' => 'testing123'
        ]);

        $this->assertNotNull($this->user->refresh()->getAttributes()['api_token']);
        $this->assertNotNull($this->user->refresh()->api_token_expiration);

        $response = json_decode($this->response->getContent(), true);

        $this->assertTrue($response['success']);
        $this->assertEquals($response['token'], $this->user->refresh()->getAttributes()['api_token']);
    }

    public function testLogout()
    {
        $this->be($this->user);

        $this->post('/logout');

        $this->assertEmpty($this->user->refresh()->getAttributes()['api_token']);
        $this->assertEquals($this->user->refresh()->api_token_expiration->getTimestamp(), -62169984000);

        $this->assertTrue(json_decode($this->response->getContent(), true)['success']);
    }

    public function testSignup()
    {
        $this->post('/signup', [
            'net_id' => 'testing123123',
            'password' => 'testing123123',
            'password_confirmation' => 'testing123123'
        ]);

        $this->assertNotNull(User::whereNetId('testing123123')->first());

        User::whereNetId('testing123123')->first()->delete();
    }

    public function testCheckAuthorized()
    {
        $this->be($this->user);

        $this->get('/check-authorized');

        $this->assertTrue(json_decode($this->response->getContent(), true)['authorized']);
    }
}