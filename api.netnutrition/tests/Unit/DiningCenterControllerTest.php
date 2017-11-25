<?php

namespace Unit;

use App\DiningCenter;
use App\Food;
use TestCase;
use function json_decode;

class DiningCenterControllerTest extends TestCase
{
    public function testIndex()
    {
        $this->get('/dining-center')
            ->assertResponseOk();
    }

    public function testShow()
    {
        $diningCenter = DiningCenter::all()->first();

        $this->get("/dining-center/{$diningCenter->id}")
            ->assertResponseOk();

        $this->get('/dining-center/0')
            ->assertResponseStatus(404);
    }

    public function testShowMenus()
    {
        $diningCenter = DiningCenter::all()->first();

        $this->get("/dining-center/{$diningCenter->id}/menus");

        foreach (json_decode($this->response->getContent(), true) as $menu) {
            $this->assertContains($menu['id'], $diningCenter->menus->map(function ($menu) {
                return $menu->id;
            }));
        }
    }

    public function testShowFoods()
    {
        $diningCenter = DiningCenter::all()->first();

        $this->get("/dining-center/{$diningCenter->id}/foods")
            ->assertResponseOk();

        foreach (json_decode($this->response->getContent(), true) as $food) {
            $food = Food::find($food['id']);
            /** @var Food $food */
            $this->assertContains($diningCenter->id, $food->menus->map(function ($menu) {
                return $menu->dining_center_id;
            }));
        }
    }
}