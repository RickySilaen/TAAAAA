<?php

namespace App\Policies;

use App\Models\LaporanBantuan;
use App\Models\User;

class LaporanBantuanPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        // Semua user yang login bisa melihat list laporan mereka sendiri
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, LaporanBantuan $laporanBantuan): bool
    {
        // Admin dan petugas bisa lihat semua
        if (in_array($user->role, ['admin', 'petugas'])) {
            return true;
        }

        // Petani hanya bisa lihat laporan mereka sendiri
        return $user->id === $laporanBantuan->user_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Hanya petani yang bisa membuat laporan
        return $user->role === 'petani';
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, LaporanBantuan $laporanBantuan): bool
    {
        // Hanya pemilik laporan yang bisa update
        // Dan hanya jika status masih pending atau rejected
        return $user->id === $laporanBantuan->user_id
            && in_array($laporanBantuan->status, ['pending', 'rejected']);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, LaporanBantuan $laporanBantuan): bool
    {
        // Admin bisa hapus semua
        if ($user->role === 'admin') {
            return true;
        }

        // Petani hanya bisa hapus laporan mereka sendiri yang masih pending
        return $user->id === $laporanBantuan->user_id
            && $laporanBantuan->status === 'pending';
    }

    /**
     * Determine whether the user can verify the model.
     */
    public function verify(User $user, LaporanBantuan $laporanBantuan): bool
    {
        // Hanya admin dan petugas yang bisa verifikasi
        return in_array($user->role, ['admin', 'petugas']);
    }

    /**
     * Determine whether the user can publish the model.
     */
    public function publish(User $user, LaporanBantuan $laporanBantuan): bool
    {
        // Hanya admin yang bisa publish ke dashboard publik
        return $user->role === 'admin';
    }
}
