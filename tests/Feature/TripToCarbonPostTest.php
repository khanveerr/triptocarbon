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
     * This test is to successfully call triptocarbon api without any error
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

    /**
     * This test is used to check if required data is missing
     * 
     * @return void
     */
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

    /**
     * This test check for invalid activity type
     * 
     * @return void
     */
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

    /**
     * This test check for invalid country
     * 
     * @return void
     */
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


    /**
     * This test check for invalid fuel type
     * 
     * @return void
     */
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

    /**
     * This test check for mode is not present if activity type is miles
     * 
     * @return void
     */
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

    /**
     * This test check for fuel type is not present if activity type is fuel
     * 
     * @return void
     */
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
