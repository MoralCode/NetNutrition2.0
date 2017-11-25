<?php

namespace Unit;

use TestCase;

class UserControllerTest extends TestCase
{
    public function testIndex()
    {
        $this->get('/')->assertResponseStatus(404);
    }
}