<?php

namespace Unit;

use TestCase;

class IndexTest extends TestCase
{
    public function testIndex()
    {
        $this->get('/')->assertResponseStatus(404);
    }
}