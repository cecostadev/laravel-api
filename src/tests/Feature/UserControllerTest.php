<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Faker\Factory as Faker;

class UserControllerTest extends TestCase
{

    private $token = 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vbG9jYWxob3N0L2FwaS9sb2dpbiIsImlhdCI6MTY4MDc4MzE1NSwiZXhwIjoxNjgwNzg2NzU1LCJuYmYiOjE2ODA3ODMxNTUsImp0aSI6InVvOThSZWFJUGJRQmQzRjkiLCJzdWIiOiIxIiwicHJ2IjoiMjNiZDVjODk0OWY2MDBhZGIzOWU3MDFjNDAwODcyZGI3YTU5NzZmNyJ9.roA24I7GJOkF3kAx44r6sN5Th37QUtaIUuYCWh4SuWY';


    public function testIndex()
    {

        $response = $this->get('/api/users', [
            'Authorization' => $this->token
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            '*' => [
                'id',
                'name',
                'email',
                'created_at',
                'updated_at'
            ]
        ]);
    }

    public function testDestroy()
    {
        $user = User::factory()->create();
        
        $response = $this->delete('/api/users/' . $user->id, [
            'Authorization' => $this->token
        ]);

        $response->assertStatus(204);

        $this->assertNull(User::find($user->id));
    }

    public function testStore()
    {   

        $faker = Faker::create();

        $user = [
            'name'  => $faker->name,
            'email' => $faker->safeEmail,
            'password' => 123456
        ];

        $response = $this->json('POST','/api/users', $user);

        $response->assertStatus(201);
    }
}
