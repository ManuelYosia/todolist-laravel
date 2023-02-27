<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
   public function testLogin()
   {
        $this->get('/login')
                ->assertSeeText("Login");
   }
   
   public function testLoginForMember()
   {
          $this->withSession([
               "user" => "manuel"
          ])->get('/login')
               ->assertRedirect('/');
   }

   public function testLoginSuccess()
   {
        $this->post('/login', [
            "user" => "manuel",
            "password" => "rahasia"
        ])->assertRedirect('/')->assertSessionHas("user", "manuel");
   }

   public function testLoginValidationError()
   {
     $this->post('/login', [])
                    ->assertSeeText("User or Password are required");
   }

   public function testLoginFailed()
   {
     $this->post('/login', [
          "user" => "manuel",
          "password" => "manuel"
     ])->assertSeeText("User or Password are wrong");
   }

   public function testLogout()
   {
     $this->withSession([
          "user" => "manuel"
     ])->post('/logout')
          ->assertRedirect('/')
          ->assertSessionMissing('user');
   }
}
