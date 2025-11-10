<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;

echo "=== CEK DATA VERIFIKASI ===\n\n";

echo "PETUGAS:\n";
$petugas_list = User::where('role', 'petugas')->get(['id', 'name', 'email', 'alamat_desa', 'alamat_kecamatan', 'is_verified']);
foreach($petugas_list as $p) {
    echo "- ID: {$p->id}, Name: {$p->name}, Desa: {$p->alamat_desa}, Kecamatan: {$p->alamat_kecamatan}, Verified: " . ($p->is_verified ? 'YA' : 'TIDAK') . "\n";
}

echo "\nPETANI BELUM VERIFIKASI:\n";
$petani_list = User::where('role', 'petani')->where('is_verified', false)->get(['id', 'name', 'email', 'alamat_desa', 'alamat_kecamatan', 'is_verified']);
foreach($petani_list as $p) {
    echo "- ID: {$p->id}, Name: {$p->name}, Desa: {$p->alamat_desa}, Kecamatan: {$p->alamat_kecamatan}, Verified: " . ($p->is_verified ? 'YA' : 'TIDAK') . "\n";
}

echo "\nPETANI SUDAH VERIFIKASI:\n";
$petani_verified = User::where('role', 'petani')->where('is_verified', true)->get(['id', 'name', 'email', 'alamat_desa', 'alamat_kecamatan', 'is_verified']);
foreach($petani_verified as $p) {
    echo "- ID: {$p->id}, Name: {$p->name}, Desa: {$p->alamat_desa}, Kecamatan: {$p->alamat_kecamatan}, Verified: " . ($p->is_verified ? 'YA' : 'TIDAK') . "\n";
}

echo "\n=== SELESAI ===\n";
