<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LaporanResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'user' => new UserResource($this->whenLoaded('user')),
            'komoditas' => $this->komoditas,
            'jenis_tanaman' => $this->jenis_tanaman,
            'luas_lahan' => $this->luas_lahan,
            'jumlah_panen' => $this->jumlah_panen,
            'tanggal_panen' => $this->tanggal_panen,
            'kualitas' => $this->kualitas,
            'harga_jual' => $this->harga_jual,
            'status' => $this->status,
            'catatan' => $this->catatan,
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
        ];
    }
}
