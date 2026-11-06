<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AduanResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
   public function toArray($request): array
{
    return [
        'id' => $this->aduan_id,
        'aduan' => $this->aduan,
        'priority' => $this->priority,
        'user' => [
            'id' => $this->user_id,
            'name' => $this->user?->name,
            'email' => $this->user?->email,
        ],
        'jenis_aduan' => [
            'id' => $this->jenis_aduan_id,
            'nama_jenis' => $this->jenisAduan?->nama_jenis,
        ],
        'created_at' => $this->created_at,
    ];
}
}
