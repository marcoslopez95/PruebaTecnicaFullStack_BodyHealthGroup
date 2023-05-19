<?php

namespace Tests\Feature;

use App\Models\PublicationCategory;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class PublicationCategoryTest extends TestCase
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

    public function test_create_publication_category_for_api(): void
    {

        // ----- Create a Role with guard_name
        $response = $this
            ->postJson(route('api.v1.publication-categories.store'), [
                'name'                  => $name = $this->faker->name(),
                'description'           => $this->faker->text(),
            ]);

        $response->assertNoContent();

        $publicationCategory = PublicationCategory::firstWhere('name', $name);
        $this->assertModelExists($publicationCategory);
    }

    public function test_not_create_publication_category_for_api_because_problem_with_validations(): void
    {
        $response = $this->postJson(route('api.v1.publication-categories.store'), []);

        $errors = [
            'name'
        ];
        $response->assertJsonValidationErrors($errors);
    }

    public function test_show_publication_category_by_id_for_api(): void
    {
        $publicationCategory = PublicationCategory::factory()->create();
        $response = $this->getJson(route('api.v1.publication-categories.show', ['publication_category' => $publicationCategory->id]));
        $response->assertOk()
            ->assertJson([
                "data" => [
                    'id' => $publicationCategory->id,
                    'name' => $publicationCategory->name,
                    'description' => $publicationCategory->description,
                    'isDeleted'  => $publicationCategory->isDeleted,
                ],
                "message" => __('generals.success-show', ['name' => 'Publication Category'])
            ]);
    }

    public function test_index_publication_category_for_api(): void
    {
        PublicationCategory::factory(3)->create();


        $response = $this->getJson(route('api.v1.publication-categories.index'));

        $publicationCategories = PublicationCategory::all();
        $response->assertOk()
            ->assertJson([
                "data" => $publicationCategories->map(function (PublicationCategory $publicationCategory) {
                    return [
                        'id' => $publicationCategory->id,
                        'name' => $publicationCategory->name,
                        'description' => $publicationCategory->description,
                        'isDeleted'  => $publicationCategory->isDeleted,
                ];
                })->toArray(),
                "message" => __('generals.success-index', ['name' => 'Publication Category'])
            ]);
    }

    public function test_update_publication_category_with_guard_name_for_api(): void
    {
        $publicationCategory = PublicationCategory::factory()->create();

        $response = $this->putJson(route('api.v1.publication-categories.update', ['publication_category' => $publicationCategory->id]), [
            'name'                  => $name = $this->faker->name(),
            'description'           => $description = $this->faker->text(),
        ]);

        $response->assertNoContent();
        $publicationCategory->refresh();
        $this->assertEquals($description, $publicationCategory->description);
        $this->assertEquals($name, $publicationCategory->name);
    }

    public function test_not_update_publication_category_for_api_because_problem_with_validations(): void
    {
        $publicationCategory = PublicationCategory::factory()->create();

        $response = $this->putJson(route('api.v1.publication-categories.update', ['publication_category' => $publicationCategory->id]), []);

        $errors = [
            'name',
        ];
        $response->assertJsonValidationErrors($errors);
    }

    public function test_destroy_publication_category_for_api(): void
    {
        $publicationCategory = PublicationCategory::factory()->create();
        $response = $this->deleteJson(route('api.v1.publication-categories.destroy', ['publication_category' => $publicationCategory->id]));

        $response->assertNoContent();
        $publicationCategory->refresh();
        $this->assertSoftDeleted($publicationCategory);
    }

    public function test_restore_publication_category_for_api(): void
    {
        $publicationCategory = PublicationCategory::factory()->create();

        $response = $this->putJson(route('api.v1.publication-categories.restore', ['publication_category' => $publicationCategory->id]));

        $response->assertNoContent();
        $publicationCategory->refresh();
        $this->assertModelExists($publicationCategory);
        $this->assertNull($publicationCategory->deleted_at);
    }
}
