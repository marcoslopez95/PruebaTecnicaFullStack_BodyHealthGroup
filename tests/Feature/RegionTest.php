<?php

namespace Tests\Feature;

use App\Models\Region;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class RegionTest extends TestCase
{
    use DatabaseTransactions, WithFaker;

    private $admin;
    protected function setUp(): void
    {
        parent::setUp();

        $role = Role::firstWhere('name', 'Admin');
        $this->admin = User::factory()->create();
        $this->admin->roles()->attach([$role->id]);

        Sanctum::actingAs(
            $this->admin,
            ['*']
        );
    }

    public function test_create_region_for_api(): void
    {

        // ----- Create a Role with guard_name
        $response = $this
            ->postJson(route('api.v1.regions.store'), [
                'name'                  => $name = $this->faker->name()
            ]);

        $response->assertNoContent();

        $region = Region::firstWhere('name', $name);
        $this->assertModelExists($region);
    }

    public function test_not_create_region_for_api_because_problem_with_validations(): void
    {
        $response = $this->postJson(route('api.v1.regions.store'), []);

        $errors = [
            'name'
        ];
        $response->assertJsonValidationErrors($errors);
    }

    public function test_show_region_by_id_for_api(): void
    {
        $region = Region::factory()->create();
        $response = $this->getJson(route('api.v1.regions.show', ['region' => $region->id]));
        $response->assertOk()
            ->assertJson([
                "data" => [
                    'id' => $region->id,
                    'name' => $region->name,
                ],
                "message" => __('generals.success-show', ['name' => 'Region'])
            ]);
    }

    public function test_index_region_for_api(): void
    {
        Region::factory(3)->create();

        $response = $this->getJson(route('api.v1.regions.index'));

        $regions = Region::all();
        $response->assertOk()
            ->assertJson([
                "data" => $regions->map(function (Region $region) {
                    return [
                        'id'         => $region->id,
                        'name'       => $region->name
                    ];
                })->toArray(),
                "message" => __('generals.success-index', ['name' => 'Region'])
            ]);
    }

    public function test_update_region_for_api(): void
    {
        $region = Region::factory()->create();

        $response = $this->putJson(route('api.v1.regions.update', ['region' => $region->id]), [
            'name'                  => $name = $this->faker->name()
        ]);

        $response->assertNoContent();
        $region->refresh();
        $this->assertEquals($name, $region->name);
    }

    public function test_not_update_region_for_api_because_problem_with_validations(): void
    {
        $region = Region::factory()->create();

        $response = $this->putJson(route('api.v1.regions.update', ['region' => $region->id]), []);

        $errors = [
            'name',
        ];
        $response->assertJsonValidationErrors($errors);
    }

    public function test_destroy_region_for_api(): void
    {
        $region = Region::factory()->create();
        $response = $this->deleteJson(route('api.v1.regions.destroy', ['region' => $region->id]));

        $response->assertNoContent();
        $region->refresh();
        $this->assertSoftDeleted($region);
    }

    public function test_restore_region_for_api(): void
    {
        $region = Region::factory()->create();

        $response = $this->putJson(route('api.v1.regions.restore', ['region' => $region->id]));

        $response->assertNoContent();
        $region->refresh();
        $this->assertModelExists($region);
        $this->assertNull($region->deleted_at);
    }
}
