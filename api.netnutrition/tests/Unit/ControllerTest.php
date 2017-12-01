<?php

namespace Unit;

use TestCase;

class ControllerTest extends TestCase
{
    public function testIndex()
    {
        $this->get('/')->assertResponseStatus(404);
    }

    public function testUnauthorized()
    {
        $this->get('/check-authorized');

        $this->assertFalse(json_decode($this->response->getContent(), true)['authorized']);
    }
}