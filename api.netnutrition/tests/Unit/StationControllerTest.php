<?php

namespace Unit;

use TestCase;

class StationControllerTest extends TestCase
{
    public function testIndex()
    {
        $this->get('/')->assertResponseStatus(404);
    }
}