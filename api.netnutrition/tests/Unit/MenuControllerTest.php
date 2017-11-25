<?php

namespace Unit;

use TestCase;

class MenuControllerTest extends TestCase
{
    public function testIndex()
    {
        $this->get('/')->assertResponseStatus(404);
    }
}