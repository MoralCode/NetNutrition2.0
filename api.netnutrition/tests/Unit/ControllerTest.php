<?php

namespace Unit;

use TestCase;

class ControllerTest extends TestCase
{
    public function testIndex()
    {
        $this->get('/')->assertResponseStatus(404);
    }
}