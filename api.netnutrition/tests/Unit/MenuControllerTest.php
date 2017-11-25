<?php

namespace Unit;

use App\Menu;
use TestCase;

class MenuControllerTest extends TestCase
{
    public function testIndex()
    {
        $this->get('/menu')
            ->assertResponseOk();
    }

    public function testShow()
    {
        $menu = Menu::all()->first();

        $this->get("/menu/{$menu->id}")
            ->assertResponseOk();

        $this->get('/menu/0')
            ->assertResponseStatus(404);
    }

    public function testShowFoods()
    {
        $menu = Menu::all()->first();

        $this->get("/menu/{$menu->id}/foods");

        foreach (json_decode($this->response->getContent(), true) as $food) {
            $this->assertContains($food['id'], $menu->foods->map(function ($food) {
                return $food->id;
            }));
        }
    }

    public function testShowNutritions()
    {
        $menu = Menu::all()->first();

        $this->get("/menu/{$menu->id}/nutritions")
            ->assertResponseOk();
    }
}