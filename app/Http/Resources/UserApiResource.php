<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserApiResource extends JsonResource
{
    protected array $allowedFields = [
        'name',
        'email',
        'gender',
        'city',
        'country',
    ];

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $requestedFields = $request->query('fields');
        // Convertcomma-separatedstringtoarray
        $fields = $requestedFields ? array_intersect( explode(',', $requestedFields), $this->allowedFields) : $this->allowedFields;
        $data=[
            'name' => $this->name,
            'email' => $this->email,
            'gender' => $this->detail->gender ?? null,
            'city' => $this->location->city ?? null,
            'country' => $this->location->country ?? null,
        ];

        return collect($data)->only($fields)->toArray();
    }
}
