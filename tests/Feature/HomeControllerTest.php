<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class HomeControllerTest extends TestCase
{
//    use RefreshDatabase;
    use WithoutMiddleware;
    public function test_example()
    {

        $user = User::factory()->create();
//        $this->actingAs($user);
//        $this->withoutExceptionHandling(); //todo helps to catch error

        $response = $this->post('/main',
        [
           'fromAccount'=>'1234',
           'toAccount'=>'12345',
           'amount'=>'123'
        ]);


        $response->assertRedirect('/main');

    }
}
