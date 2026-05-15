<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('wargas', function (Blueprint $table) {
            // Jika kolom 'status' (lama) ada dan 'jenis_warga' (baru) belum ada, rename saja
            if (Schema::hasColumn('wargas', 'status') && !Schema::hasColumn('wargas', 'jenis_warga')) {
                // Kita tidak bisa pakai renameColumn di InfinityFree tanpa library tambahan
                // Jadi lebih aman tambah baru lalu copy data
            }

            if (!Schema::hasColumn('wargas', 'jenis_warga')) {
                $table->string('jenis_warga')->nullable()->default('Pribumi')->after('nama_warga');
            }

            if (!Schema::hasColumn('wargas', 'status')) {
                $table->enum('status', ['aktif', 'pindah', 'tidak_aktif'])->default('aktif')->after('jenis_warga');
            }

            if (!Schema::hasColumn('wargas', 'tgl_keluar_warga')) {
                $table->date('tgl_keluar_warga')->nullable()->after('tgl_masuk_warga');
            }
        });

        // Copy data dari status lama ke jenis_warga jika perlu
        try {
             \DB::statement("UPDATE wargas SET jenis_warga = status WHERE jenis_warga IS NULL");
        } catch (\Exception $e) {
            // Abaikan jika kolom status tidak ada atau formatnya beda
        }
    }

    public function down(): void
    {
        Schema::table('wargas', function (Blueprint $table) {
            $table->dropColumn(['jenis_warga', 'status', 'tgl_keluar_warga']);
        });
    }
};
