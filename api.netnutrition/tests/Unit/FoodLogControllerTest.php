<?php

namespace Unit;

use TestCase;

class FoodLogControllerTest extends TestCase
{
    public function testIndex()
    {
        $this->get('/')->assertResponseStatus(404);
    }
}