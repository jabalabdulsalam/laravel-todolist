<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TodolistControllerTest extends TestCase
{
    public function testTodolist()
    {
        $this->withSession([
            "user" => "jabal",
            "todolist" => [
                [
                    "id" => "1",
                    "todo" => "Jabal"
                ],
                [
                    "id" => "2",
                    "todo" => "Abdul"
                ]
            ]
        ])->get('/todolist')
            ->assertSeeText("1")
            ->assertSeeText("Jabal")
            ->assertSeeText("2")
            ->assertSeeText("Abdul");
    }

    public function testAddTodoFailed()
    {
        $this->withSession([
            "user" => "jabal"
        ])->post("/todolist",[])
            ->assertSeeText("Todo is Required");
    }

    public function testAddTodoSuccess()
    {
        $this->withSession([
            "user" => "jabal"
        ])->post("/todolist",[
            "todo" => "Jabal"
        ])->assertRedirect("/todolist");
    }

    public function testRemoveTodolist()
    {
        $this->withSession([
            "user" => "jabal",
            "todolist" => [
                [
                    "id" => "1",
                    "todo" => "Jabal"
                ],
                [
                    "id" => "2",
                    "todo" => "Abdul"
                ]
            ]
        ])->post("todolist/1/delete")
            ->assertRedirect("/todolist");
    }
}
