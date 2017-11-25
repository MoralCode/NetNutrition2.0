<?php

namespace Unit;

use TestCase;

class FoodControllerTest extends TestCase
{
    public function testIndex()
    {
        $this->get('/')->assertResponseStatus(404);
    }
}