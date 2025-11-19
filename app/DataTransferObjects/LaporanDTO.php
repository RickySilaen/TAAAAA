<?php

namespace App\DataTransferObjects;

/**
 * Laporan Data Transfer Object.
 *
 * Immutable data container for harvest report information.
 * Used to transfer data between layers with type safety.
 */
class LaporanDTO extends BaseDTO
{
    /**
     * Constructor.
     */
    public function __construct(
        public readonly ?int $id = null,
        public readonly ?int $userId = null,
        public readonly ?string $namaPetani = null,
        public readonly ?string $alamatDesa = null,
        public readonly ?string $komoditas = null,
        public readonly ?string $jenisTanaman = null,
        public readonly ?float $luasLahan = null,
        public readonly ?float $jumlahPanen = null,
        public readonly ?string $tanggalPanen = null,
        public readonly ?string $kualitas = null,
        public readonly ?float $hargaJual = null,
        public readonly ?string $status = 'pending',
        public readonly ?string $catatan = null,
        public readonly ?string $foto = null,
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
            'komoditas',
            'jenis_tanaman',
            'luas_lahan',
            'jumlah_panen',
            'tanggal_panen',
        ]);

        $this->validateTypes([
            'komoditas' => 'string',
            'jenis_tanaman' => 'string',
            'tanggal_panen' => 'string',
        ]);

        // Validate numeric values
        if ($this->luasLahan !== null && $this->luasLahan <= 0) {
            throw new \InvalidArgumentException('Luas lahan harus lebih dari 0');
        }

        if ($this->jumlahPanen !== null && $this->jumlahPanen <= 0) {
            throw new \InvalidArgumentException('Jumlah panen harus lebih dari 0');
        }

        if ($this->hargaJual !== null && $this->hargaJual < 0) {
            throw new \InvalidArgumentException('Harga jual tidak boleh negatif');
        }

        // Validate kualitas
        if ($this->kualitas !== null) {
            $validQualities = ['baik', 'sedang', 'buruk'];
            if (! in_array($this->kualitas, $validQualities)) {
                throw new \InvalidArgumentException(
                    'Kualitas harus salah satu dari: ' . implode(', ', $validQualities)
                );
            }
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
            $validStatuses = ['pending', 'terverifikasi', 'ditolak'];
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

    /**
     * Calculate productivity (jumlah_panen / luas_lahan).
     */
    public function getProductivity(): ?float
    {
        if ($this->jumlahPanen === null || $this->luasLahan === null || $this->luasLahan == 0) {
            return null;
        }

        return round($this->jumlahPanen / $this->luasLahan, 2);
    }

    /**
     * Calculate total revenue (jumlah_panen * harga_jual).
     */
    public function getTotalRevenue(): ?float
    {
        if ($this->jumlahPanen === null || $this->hargaJual === null) {
            return null;
        }

        return round($this->jumlahPanen * $this->hargaJual, 2);
    }
}
