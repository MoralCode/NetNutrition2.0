<?php

namespace Unit;

use TestCase;

class DiningCenterControllerTest extends TestCase
{
    public function testIndex()
    {
        $this->get('/')->assertResponseStatus(404);
    }
}