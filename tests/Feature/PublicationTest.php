<?php

namespace Tests\Feature;

use App\Models\ExternalReference;
use App\Models\Publication;
use App\Models\PublicationCategory;
use App\Models\Region;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class PublicationTest extends TestCase
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

    public function test_not_create_publication_for_api_because_problem_with_validations(): void
    {
        $response = $this->postJson(route('api.v1.publications.store'), []);

        $errors = [
            'content',
            'publication_category_id',
        ];
        $response->assertJsonValidationErrors($errors);

        $response = $this->postJson(route('api.v1.publications.store'), [
            'labels'              => [1],
            'region_id'           => 0,
            'external_references' => ['a'],
        ]);

        $errors = [
            'content',
            'publication_category_id',
            'labels.0',
            'region_id',
            'external_references.0',
        ];
        $response->assertJsonValidationErrors($errors);
    }

    public function test_create_publication_for_api_with_all_fields(): void
    {
        $labels = [];

        for ($i = 1; $i <= $this->faker->randomDigitNotZero(); $i++) {
            $labels[] = $this->faker->word();
        }
        $externalReference =  ExternalReference::factory(5)->create()->random(rand(1, 5));
        $region = Region::factory(5)->create()->random()->first();
        $publicationCategory = PublicationCategory::factory()->create();
        $response = $this
            ->postJson(route('api.v1.publications.store'), [
                'content'                 => $this->faker->name(),
                'labels'                  => $labels,
                'region_id'               => $region->id,
                'external_references'     => $externalReference->modelKeys(),
                'publication_category_id' => $publicationCategory->id
            ]);

        $response->assertNoContent();

        $publication = Publication::first();
        $this->assertModelExists($publication);

        $this->assertCount($externalReference->count(), $publication->externalReferences);
        $this->assertEquals($region->name, $publication->region->name);
        $this->assertEquals($publicationCategory->name, $publication->publicationCategory->name);
    }

    public function test_create_publication_for_api_with_only_requerid_fields(): void
    {

        $publicationCategory = PublicationCategory::factory()->create();
        $response = $this
            ->postJson(route('api.v1.publications.store'), [
                'content'                 => $this->faker->name(),
                'publication_category_id' => $publicationCategory->id
            ]);

        $response->assertNoContent();

        $publication = Publication::first();
        $this->assertModelExists($publication);

        $this->assertEquals($publicationCategory->name, $publication->publicationCategory->name);
    }

    public function test_show_publication_by_id_for_api(): void
    {
        $publication = Publication::factory()
            ->for(Region::factory()->create())
            ->for(PublicationCategory::factory()->create())
            ->for(User::factory()->create())
            ->has(ExternalReference::factory()->count(3))
            ->create();
        $response = $this->getJson(route('api.v1.publications.show', ['publication' => $publication->id]));
        $response->assertOk()
            ->assertJson([
                "data" => [
                    'id' => $publication->id,
                    'content' => $publication->content,
                    'labels' => $publication->labels,
                    'isDeleted'  => $publication->isDeleted,
                    'created_at'  => $publication->created_at->toString(),
                    'region'  => [
                        'id' => $publication->region->id,
                        'name' => $publication->region->name,
                        'isDeleted'  => $publication->region->isDeleted,
                    ],
                    'external_references'  => $publication->ExternalReferences
                        ->map(function (ExternalReference $externalReference) {
                            return [
                                'id' => $externalReference->id,
                                'name' => $externalReference->name,
                                'url' => $externalReference->url,
                                'isDeleted'  => $externalReference->isDeleted,
                            ];
                        })->toArray(),
                    'publication_category'  => [
                        'id' => $publication->publicationCategory->id,
                        'name' => $publication->publicationCategory->name,
                        'description' => $publication->publicationCategory->description,
                        'isDeleted'  => $publication->publicationCategory->isDeleted,
                    ],
                ],
                "message" => __('generals.success-show', ['name' => 'Publication'])
            ]);
    }

    public function test_index_publication_for_api(): void
    {
        $publications = Publication::factory(4)
            ->for(Region::factory()->create())
            ->for(PublicationCategory::factory()->create())
            ->for(User::factory()->create())
            ->has(ExternalReference::factory()->count(3))
            ->create();

        $response = $this->getJson(route('api.v1.publications.index'));

        $publications = Publication::all();
        $response->assertOk()
            ->assertJson([
                "data" => $publications->map(function (Publication $publication) {
                    return [
                        'id' => $publication->id,
                        'content' => $publication->content,
                        'labels' => $publication->labels,
                        'isDeleted'  => $publication->isDeleted,
                        'created_at'  => $publication->created_at->toString(),
                        'region'  => [
                            'id' => $publication->region->id,
                            'name' => $publication->region->name,
                            'isDeleted'  => $publication->region->isDeleted,
                        ],
                        'external_references'  => $publication->ExternalReferences
                            ->map(function (ExternalReference $externalReference) {
                                return [
                                    'id' => $externalReference->id,
                                    'name' => $externalReference->name,
                                    'url' => $externalReference->url,
                                    'isDeleted'  => $externalReference->isDeleted,
                                ];
                            })->toArray(),
                        'publication_category'  => [
                            'id' => $publication->publicationCategory->id,
                            'name' => $publication->publicationCategory->name,
                            'description' => $publication->publicationCategory->description,
                            'isDeleted'  => $publication->publicationCategory->isDeleted,
                        ],
                    ];
                })->toArray(),
                "message" => __('generals.success-index', ['name' => 'Publication'])
            ]);
    }

    public function test_not_update_publication_for_api_because_problem_with_validations(): void
    {
        $publication = Publication::factory()
            ->for(Region::factory()->create())
            ->for(PublicationCategory::factory()->create())
            ->for(User::factory()->create())
            ->has(ExternalReference::factory()->count(3))
            ->create();
        $response = $this->putJson(route('api.v1.publications.update', ['publication' => $publication->id]), []);

        $errors = [
            'content',
            'publication_category_id',
        ];
        $response->assertJsonValidationErrors($errors);

        $response = $this->putJson(route('api.v1.publications.update', ['publication' => $publication->id]), [
            'labels'              => [1],
            'region_id'           => 0,
            'external_references' => ['a'],
        ]);

        $errors = [
            'publication_category_id',
            'labels.0',
            'region_id',
            'external_references.0',
        ];
        $response->assertJsonValidationErrors($errors);
    }

    public function test_update_publication_for_api_with_all_fields(): void
    {
        $publication = Publication::factory()
            ->for(Region::factory()->create())
            ->for(PublicationCategory::factory()->create())
            ->for(User::factory()->create())
            ->has(ExternalReference::factory()->count(3))
            ->create();

        $labels = [];

        for ($i = 1; $i <= $this->faker->randomDigitNotZero(); $i++) {
            $labels[] = $this->faker->word();
        }
        $externalReference =  ExternalReference::factory(5)->create()->random(rand(1, 5));
        $region = Region::factory(5)->create()->random()->first();
        $publicationCategory = PublicationCategory::factory()->create();
        $response = $this
            ->putJson(route('api.v1.publications.update', ['publication' => $publication->id]), [
                'content'                 => $content = $this->faker->text(),
                'labels'                  => $labels,
                'region_id'               => $region->id,
                'external_references'     => $externalReference->modelKeys(),
                'publication_category_id' => $publicationCategory->id
            ]);

        $response->assertNoContent();

        $publication->refresh();

        $this->assertEquals($content, $publication->content);
        $this->assertEquals($labels, $publication->labels);

        // Validations relationships
        $this->assertCount($externalReference->count(), $publication->externalReferences);
        $this->assertEquals($region->name, $publication->region->name);
        $this->assertEquals($publicationCategory->name, $publication->publicationCategory->name);
    }

    public function test_update_publication_for_api_with_only_requerid_fields(): void
    {
        $publication = Publication::factory()
            ->for(Region::factory()->create())
            ->for(PublicationCategory::factory()->create())
            ->for(User::factory()->create())
            ->has(ExternalReference::factory()->count(3))
            ->create();

        $publicationCategory = PublicationCategory::factory()->create();
        $response = $this
            ->putJson(route('api.v1.publications.update', ['publication' => $publication->id]), [
                'content'                 => $content = $this->faker->text(),
                'publication_category_id' => $publicationCategory->id
            ]);

        $response->assertNoContent();

        $publication->refresh();

        $this->assertEquals($content, $publication->content);

        // Validations relationships
        $this->assertEquals($publicationCategory->name, $publication->publicationCategory->name);
    }

    public function test_destroy_publication_for_api(): void
    {
        $publication = Publication::factory()
            ->for(Region::factory()->create())
            ->for(PublicationCategory::factory()->create())
            ->for(User::factory()->create())
            ->has(ExternalReference::factory()->count(3))
            ->create();
        $response = $this->deleteJson(route('api.v1.publications.destroy', ['publication' => $publication->id]));

        $response->assertNoContent();
        $publication->refresh();
        $this->assertSoftDeleted($publication);
    }

    public function test_restore_publication_for_api(): void
    {
        $publication = Publication::factory()
            ->for(Region::factory()->create())
            ->for(PublicationCategory::factory()->create())
            ->for(User::factory()->create())
            ->has(ExternalReference::factory()->count(3))
            ->create();
        $publication->delete();

        $response = $this->putJson(route('api.v1.publications.restore', ['publication' => $publication->id]));

        $response->assertNoContent();
        $publication->refresh();
        $this->assertModelExists($publication);
        $this->assertNull($publication->deleted_at);
    }

    public function test_index_publication_for_dashboard_with_paginated(): void
    {

        $publications = Publication::limit(15)->get();
        if ($publications->count() == 0) {
            $publications = Publication::factory(2)
                ->for(Region::factory()->create())
                ->for(PublicationCategory::factory()->create())
                ->for(User::factory()->create())
                ->has(ExternalReference::factory()->count(3))
                ->create();
        }
        $response = $this->getJson(route('api.v1.publications.index', [
            'paginated'   => 1,
            'currentPage' => 1,
            'perPage' => 30
        ]));
        $response->assertOk()
            ->assertJson([
                "data" => [
                    'data' => $publications->map(function (Publication $publication) {
                        return [
                            'id' => $publication->id,
                            'content' => $publication->content,
                            'labels' => $publication->labels,
                            'isDeleted'  => $publication->isDeleted,
                            'created_at' => (string) \Carbon\Carbon::parse($publication->created_at)->format('m-d-Y H:i'),
                            'region'  => [
                                'id' => $publication->region->id,
                                'name' => $publication->region->name,
                                'isDeleted'  => $publication->region->isDeleted,
                            ],
                            'external_references'  => $publication->ExternalReferences
                                ->map(function (ExternalReference $externalReference) {
                                    return [
                                        'id' => $externalReference->id,
                                        'name' => $externalReference->name,
                                        'url' => $externalReference->url,
                                        'isDeleted'  => $externalReference->isDeleted,
                                    ];
                                })->toArray(),
                            'publication_category'  => [
                                'id' => $publication->publicationCategory->id,
                                'name' => $publication->publicationCategory->name,
                                'description' => $publication->publicationCategory->description,
                                'isDeleted'  => $publication->publicationCategory->isDeleted,
                            ],
                        ];
                    })->toArray()
                ],
                "message" => __('generals.success-index', ['name' => 'Publication'])
            ]);
    }
}
