<?php

namespace Tests\Feature;

use App\Models\ExternalReference;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class ExternalReferenceTest extends TestCase
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

    public function test_create_external_reference_for_api(): void
    {

        // ----- Create a Role with guard_name
        $response = $this
            ->postJson(route('api.v1.external-references.store'), [
                'name'      => $name = $this->faker->name(),
                'url'       => $this->faker->url()
            ]);

        $response->assertNoContent();

        $externalReference = ExternalReference::firstWhere('name', $name);
        $this->assertModelExists($externalReference);
    }

    public function test_not_create_external_reference_for_api_because_problem_with_validations(): void
    {
        $response = $this->postJson(route('api.v1.external-references.store'), []);

        $errors = [
            'name'
        ];
        $response->assertJsonValidationErrors($errors);
    }

    public function test_show_external_reference_by_id_for_api(): void
    {
        $ExternalReference = ExternalReference::factory()->create();
        $response = $this->getJson(route('api.v1.external-references.show', ['external_reference' => $ExternalReference->id]));
        $response->assertOk()
            ->assertJson([
                "data" => [
                    'id' => $ExternalReference->id,
                    'name' => $ExternalReference->name,
                    'url' => $ExternalReference->url,
                    'isDeleted'  => $ExternalReference->isDeleted,
                ],
                "message" => __('generals.success-show', ['name' => 'External References'])
            ]);
    }

    public function test_index_external_reference_for_api(): void
    {
        ExternalReference::factory(3)->create();

        $response = $this->getJson(route('api.v1.external-references.index'));

        $ExternalReferences = ExternalReference::all();
        $response->assertOk()
            ->assertJson([
                "data" => $ExternalReferences->map(function (ExternalReference $ExternalReference) {
                    return [
                        'id'         => $ExternalReference->id,
                        'name'       => $ExternalReference->name,
                        'url'       => $ExternalReference->url,
                        'isDeleted'  => $ExternalReference->isDeleted,
                ];
                })->toArray(),
                "message" => __('generals.success-index', ['name' => 'External References'])
            ]);
    }

    public function test_update_external_reference_for_api(): void
    {
        $ExternalReference = ExternalReference::factory()->create();

        $response = $this->putJson(route('api.v1.external-references.update', ['external_reference' => $ExternalReference->id]), [
            'name'                  => $name = $this->faker->name(),
            'url'       => $url = $this->faker->url()
        ]);

        $response->assertNoContent();
        $ExternalReference->refresh();
        $this->assertEquals($name, $ExternalReference->name);
        $this->assertEquals($url, $ExternalReference->url);
    }

    public function test_not_update_external_reference_for_api_because_problem_with_validations(): void
    {
        $ExternalReference = ExternalReference::factory()->create();

        $response = $this->putJson(route('api.v1.external-references.update', ['external_reference' => $ExternalReference->id]), []);

        $errors = [
            'name',
        ];
        $response->assertJsonValidationErrors($errors);
    }

    public function test_destroy_external_reference_for_api(): void
    {
        $ExternalReference = ExternalReference::factory()->create();
        $response = $this->deleteJson(route('api.v1.external-references.destroy', ['external_reference' => $ExternalReference->id]));

        $response->assertNoContent();
        $ExternalReference->refresh();
        $this->assertSoftDeleted($ExternalReference);
    }

    public function test_restore_external_reference_for_api(): void
    {
        $ExternalReference = ExternalReference::factory()->create();

        $response = $this->putJson(route('api.v1.external-references.restore', ['external_reference' => $ExternalReference->id]));

        $response->assertNoContent();
        $ExternalReference->refresh();
        $this->assertModelExists($ExternalReference);
        $this->assertNull($ExternalReference->deleted_at);
    }
}
