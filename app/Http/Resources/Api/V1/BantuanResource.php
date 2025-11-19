<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BantuanResource extends JsonResource
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
            'jenis_bantuan' => $this->jenis_bantuan,
            'jumlah' => $this->jumlah,
            'alasan' => $this->alasan,
            'tanggal_permintaan' => $this->tanggal_permintaan,
            'status' => $this->status,
            'keterangan' => $this->keterangan,
            'catatan' => $this->catatan,
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
        ];
    }
}
