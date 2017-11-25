<?php

namespace Unit;

use App\Food;
use App\Nutrition;
use TestCase;

class FoodControllerTest extends TestCase
{
    public function testIndex()
    {
        $this->get('/food')
            ->assertResponseOk();
    }

    public function testShow()
    {
        $food = Food::all()->first();

        $this->get("/food/{$food->id}")
            ->assertResponseOk();

        $this->get('/food/0')
            ->assertResponseStatus(404);
    }

    public function testShowNutritions()
    {
        $food = Food::all()->first();

        $this->get("/food/{$food->id}/nutritions")
            ->assertResponseOk();

        foreach (json_decode($this->response->getContent(), true) as $nutrition) {
            $nutrition = Nutrition::find($nutrition['id']);
            /** @var Nutrition $nutrition */
            $this->assertContains($food->id, $nutrition->food()->get()->map(function ($food) {
                return $food->id;
            }));
        }
    }
}