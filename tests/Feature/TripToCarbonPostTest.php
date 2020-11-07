<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;
use App\Participant;

class TripToCarbonPostTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testsTripToCarbonCreatedSuccessfully()
    {
        $payload = [
            "activity" => 100,
            "activityType"  => "miles",
            "country"  => "usa",
            "mode"  => "taxi"
        ];

        $user = factory(User::class)->create(['email' => 'user@test.com']);
        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];

        $this->json('post', '/api/triptocarbon', $payload, $headers)
            ->assertStatus(200)
            ->assertJsonStructure([
                'carbonFootprint'
            ]);;
    }


    public function testsAllRequireData()
    {
        $user = factory(User::class)->create(['email' => 'user@test.com']);
        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];

        $this->json('post', '/api/triptocarbon', [], $headers)
            ->assertStatus(400)
            ->assertJson([
                "errors" => [
                    "activity" => [
                        "The activity field is required."
                    ],
                    "activityType" => [
                        "The activity type field is required."
                    ],
                    "country" => [
                        "The country field is required."
                    ]
                ]
            ]);
    }


    public function testsInvalidActivityType()
    {
        $payload = [
            "activity" => 100,
            "activityType"  => "miles1",
            "country"  => "usa",
            "mode"  => "taxi"
        ];

        $user = factory(User::class)->create(['email' => 'user@test.com']);
        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];

        $this->json('post', '/api/triptocarbon', $payload, $headers)
            ->assertStatus(400)
            ->assertJson([
                "errors" => [
                    "activityType" => [
                        "The selected activity type is invalid."
                    ]
                ]
            ]);
    }

    public function testsInvalidCountry()
    {
        $payload = [
            "activity" => 100,
            "activityType"  => "miles",
            "country"  => "usa11",
            "mode"  => "taxi"
        ];

        $user = factory(User::class)->create(['email' => 'user@test.com']);
        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];

        $this->json('post', '/api/triptocarbon', $payload, $headers)
            ->assertStatus(400)
            ->assertJson([
                "errors" => [
                    "country" => [
                        "The selected country is invalid."
                    ]
                ]
            ]);
    }


    public function testsInvalidFuelType()
    {
        $payload = [
            "activity" => 100,
            "activityType"  => "fuel",
            "country"  => "usa",
            "fuelType"  => "taxi11"
        ];

        $user = factory(User::class)->create(['email' => 'user@test.com']);
        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];

        $this->json('post', '/api/triptocarbon', $payload, $headers)
            ->assertStatus(400)
            ->assertJson([
                "errors" => [
                    "fuelType" => [
                        "The selected fuel type is invalid."
                    ]
                ]
            ]);
    }

    public function testsMilesActivityTypeModeRequired()
    {
        $payload = [
            "activity" => 100,
            "activityType"  => "miles",
            "country"  => "usa"
        ];

        $user = factory(User::class)->create(['email' => 'user@test.com']);
        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];

        $this->json('post', '/api/triptocarbon', $payload, $headers)
            ->assertStatus(400)
            ->assertJson([
                "errors" => [
                    "mode" => [
                        "For miles activity type, mode is required"
                    ]
                ]
            ]);
    }

    public function testsFuelActivityTypeFuelTypeRequired()
    {
        $payload = [
            "activity" => 100,
            "activityType"  => "fuel",
            "country"  => "usa"
        ];

        $user = factory(User::class)->create(['email' => 'user@test.com']);
        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];

        $this->json('post', '/api/triptocarbon', $payload, $headers)
            ->assertStatus(400)
            ->assertJson([
                "errors" => [
                    "fuelType" => [
                        "For fuel activity type, fuel type is required"
                    ]
                ]
            ]);
    }


}
