<?php

namespace App\DataTransferObjects;

/**
 * Bantuan Data Transfer Object.
 *
 * Immutable data container for aid request information.
 * Used to transfer data between layers with type safety.
 */
class BantuanDTO extends BaseDTO
{
    /**
     * Constructor.
     */
    public function __construct(
        public readonly ?int $id = null,
        public readonly ?int $userId = null,
        public readonly ?string $jenisBantuan = null,
        public readonly ?int $jumlah = null,
        public readonly ?string $alasan = null,
        public readonly ?string $tanggalPermintaan = null,
        public readonly ?string $status = 'menunggu',
        public readonly ?string $keterangan = null,
        public readonly ?string $catatan = null,
        public readonly ?string $dokumen = null,
    ) {}

    /**
     * Validate for creation.
     *
     *
     * @throws \InvalidArgumentException
     */
    public function validateForCreate(): void
    {
        $this->validateRequired([
            'user_id',
            'jenis_bantuan',
            'jumlah',
            'alasan',
            'tanggal_permintaan',
        ]);

        $this->validateTypes([
            'user_id' => 'integer',
            'jenis_bantuan' => 'string',
            'jumlah' => 'integer',
            'alasan' => 'string',
            'tanggal_permintaan' => 'string',
        ]);

        // Validate jenis_bantuan
        $validTypes = ['pupuk', 'bibit', 'pestisida', 'alat_pertanian', 'dana_usaha', 'lainnya'];
        if (! in_array($this->jenisBantuan, $validTypes)) {
            throw new \InvalidArgumentException(
                'Jenis bantuan harus salah satu dari: ' . implode(', ', $validTypes)
            );
        }

        // Validate jumlah
        if ($this->jumlah <= 0) {
            throw new \InvalidArgumentException('Jumlah harus lebih dari 0');
        }
    }

    /**
     * Validate for update.
     *
     *
     * @throws \InvalidArgumentException
     */
    public function validateForUpdate(): void
    {
        if ($this->id === null) {
            throw new \InvalidArgumentException('ID is required for update');
        }

        // Validate status if provided
        if ($this->status !== null) {
            $validStatuses = ['menunggu', 'disetujui', 'ditolak'];
            if (! in_array($this->status, $validStatuses)) {
                throw new \InvalidArgumentException(
                    'Status harus salah satu dari: ' . implode(', ', $validStatuses)
                );
            }
        }
    }

    /**
     * Get data for database insertion.
     */
    public function toDatabase(): array
    {
        return $this->toArrayWithoutNulls();
    }
}
