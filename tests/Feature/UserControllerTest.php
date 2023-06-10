<?php

namespace Tests\Feature;

use App\Actions\User\CreateUserAction;
use App\Enums\GeneralStatusEnum;
use App\Enums\RolesEnum;
use App\Http\Requests\User\UserRequest;
use App\Models\Commune;
use App\Models\Region;
use App\Models\User;
use Database\Seeders\RolesSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\JsonResponse;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->seed(RolesSeeder::class);

        Region::factory()->create();
        Commune::factory()->create();

        $user = User::factory()->create([
            'status' => GeneralStatusEnum::Active,
        ]);

        $user->syncRoles('administrator');
        $this->actingAs($user);
    }

    /**
     * Test Index without filters
     */
    public function testIndexWithoutFilters(): void
    {
        $response = $this->getJson('/users');
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'data' => [
                'current_page',
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'email',
                    ]
                ],
                'total',
                'per_page',
                'last_page'
            ],
            'code'
        ]);
    }


    /**
     * Text index with filters
     * @return void
     */
    public function testIndexFiltering()
    {
        $user1 = User::factory()->create([
            'status' => GeneralStatusEnum::Active,
        ]);
        $user1->syncRoles('administrator');

        $user2 = User::factory()->create([
            'status' => GeneralStatusEnum::Inactive,
        ]);
        $user2->syncRoles('administrator');

        $user1 = User::factory()->create([
            'status' => GeneralStatusEnum::Active,
        ]);
        $user1->syncRoles('customer');

        $user2 = User::factory()->create([
            'status' => GeneralStatusEnum::Inactive,
        ]);
        $user2->syncRoles('customer');

        $combinations = [
            ['url' => '/users?status=' . GeneralStatusEnum::Active . '&role='. RolesEnum::Administrator, 'expectedCount' => 2],
            ['url' => '/users?status=' . GeneralStatusEnum::Inactive . '&role='. RolesEnum::Customer, 'expectedCount' => 1],
            ['url' => '/users?role='. RolesEnum::Administrator, 'expectedCount' => 2],
            ['url' => '/users?role='. RolesEnum::Customer, 'expectedCount' => 1],
            ['url' => '/users', 'expectedCount' => 3],
        ];

        foreach ($combinations as $combination) {
            $response = $this->get($combination['url']);

            $this->assertInstanceOf(JsonResponse::class, $response->baseResponse);
            $responseData = $response->json();

            $this->assertCount($combination['expectedCount'], $responseData['data']['data']);
        }
    }

}
