<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('wargas', function (Blueprint $table) {
            // Rename existing status (Pribumi/Pendatang) to jenis_warga
            if (Schema::hasColumn('wargas', 'status') && !Schema::hasColumn('wargas', 'jenis_warga')) {
                $table->renameColumn('status', 'jenis_warga');
            }

            // Add new status column for membership (aktif, pindah, tidak_aktif)
            if (!Schema::hasColumn('wargas', 'status')) {
                $table->enum('status', ['aktif', 'pindah', 'tidak_aktif'])->default('aktif')->after('nama_warga');
            }

            // Add date when the citizen left/moved
            if (!Schema::hasColumn('wargas', 'tgl_keluar_warga')) {
                $table->date('tgl_keluar_warga')->nullable()->after('tgl_masuk_warga');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('wargas', function (Blueprint $table) {
            if (Schema::hasColumn('wargas', 'jenis_warga')) {
                $table->renameColumn('jenis_warga', 'status');
            }
            $table->dropColumn(['status', 'tgl_keluar_warga']);
        });
    }
};
