<?php

namespace Unit;

use App\Station;
use TestCase;

class StationControllerTest extends TestCase
{
    public function testIndex()
    {
        $this->get('/station')
            ->assertResponseOk();
    }


    public function testShow()
    {
        $station = Station::all()->first();

        $this->get("/station/{$station->id}")
            ->assertResponseOk();

        $this->get('/station/0')
            ->assertResponseStatus(404);
    }

    public function testShowMenus()
    {
        $station = Station::all()->first();

        $this->get("/station/{$station->id}/menus");

        foreach (json_decode($this->response->getContent(), true) as $menu) {
            $this->assertContains($menu['id'], $station->menus->map(function ($menu) {
                return $menu->id;
            }));
        }
    }

    public function testShowFoods()
    {
        $station = Station::all()->first();

        $this->get("/station/{$station->id}/foods")
            ->assertResponseOk();
    }
}