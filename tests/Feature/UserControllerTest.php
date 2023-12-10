<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    public function testLoginPage()
    {
        $this->get('/login')
            ->assertSeeText('Login');
    }

    public function testLoginPageForMember()
    {
        $this->withSession([
            "user" => "jabal"
        ])->get('/login')
            ->assertRedirect("/");

    }


    public function testLoginSuccess()
    {
        $this->post('/login',[
           "user" => "jabal",
           "password" => "rahasia"
        ])->assertRedirect("/")->assertSessionHas("user", "jabal");
    }

    public function testLoginForUserAlreadyLogin()
    {
        $this->withSession([
            "user" => "jabal"
        ])->post('/login',[
            "user" => "jabal",
            "password" => "rahasia"
        ])->assertRedirect("/");
    }

    public function testLoginValidationError()
    {
        $this->post("/login",[])
            ->assertSeeText("User or Password is Required");
    }

    public function testLoginFailed()
    {
        $this->post("/login",[
           "user" => "wrong",
            "password" => "wrong"
        ])->assertSeeText("User or Password is Wrong");
    }

    public function testLogoutMember()
    {
        $this->withSession([
            "user" => "jabal"
        ])->post('/logout')
            ->assertRedirect("/")
            ->assertSessionMissing("user");
    }

    public function testLogoutGuest()
    {
        $this->post('/logout')
            ->assertRedirect("/");
    }
}
