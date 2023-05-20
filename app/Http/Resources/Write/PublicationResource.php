<?php

namespace App\Http\Resources\Write;

use App\Http\Resources\Admin\Config\ExternalReferenceResource;
use App\Http\Resources\Admin\Config\PublicationCategoryResource;
use App\Http\Resources\Admin\Config\RegionResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PublicationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'content' => $this->resource->content,
            'labels' => $this->resource->labels,
            'isDeleted'  => $this->resource->isDeleted,
            'created_at'  => $this->resource->created_at->toString(),
            'region'  => $this->whenLoaded('region', fn () => RegionResource::make($this->resource->region)),
            'external_references'  => $this->whenLoaded('externalReferences', function () {
                return ExternalReferenceResource::collection($this->resource->externalReferences);
            }),
            'publication_category'  => $this->whenLoaded('publicationCategory', function () {
                return PublicationCategoryResource::make($this->resource->publicationCategory);
            }),
        ];
    }
}
