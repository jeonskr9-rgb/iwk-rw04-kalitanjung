<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

\Illuminate\Support\Facades\Artisan::call('view:clear');

// --- RUTE HALAMAN BARU TENTANG KAMI ---
Route::get('/tentang-kami', function () {
    return view('tentang_kami'); 
})->name('tentang.kami');
// --------------------------------------

Route::get('/force-migrate', function () {
    try {
        \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
        return "Migration Success: " . \Illuminate\Support\Facades\Artisan::output();
    } catch (\Exception $e) {
        return "Migration Error: " . $e->getMessage();
    }
});

    // FITUR RESET DATA (Gunakan dengan hati-hati!)
    Route::get('/reset-laporan', function() {
        \DB::statement('SET FOREIGN_KEY_CHECKS=0');
        \App\Models\TransaksiKas::truncate();
        \DB::statement('SET FOREIGN_KEY_CHECKS=1');
        return "SUKSES: Semua riwayat iuran/laporan telah dikosongkan. Data warga tetap aman.";
    });

    Route::get('/reset-total', function() {
        \DB::statement('SET FOREIGN_KEY_CHECKS=0');
        \App\Models\TransaksiKas::truncate();
        \App\Models\Warga::truncate();
        \App\Models\KartuKeluarga::truncate();
        \DB::statement('SET FOREIGN_KEY_CHECKS=1');
        return "SUKSES: Seluruh data (Warga, KK, dan Laporan) telah dikosongkan total.";
    });

Route::get('/fix-db', function() {
    try {
        // Coba cara standar
        Schema::table('wargas', function ($table) {
            $table->string('status', 50)->nullable()->change();
            $table->string('jenis_warga', 50)->nullable()->change();
        });
    } catch (\Exception $e) {
        // Cara paksa untuk InfinityFree
        try {
            \DB::statement("ALTER TABLE wargas MODIFY status VARCHAR(50) NULL");
            \DB::statement("ALTER TABLE wargas MODIFY jenis_warga VARCHAR(50) NULL");
            \DB::statement("ALTER TABLE wargas MODIFY nik VARCHAR(20) NULL");
            \DB::statement("ALTER TABLE wargas MODIFY no_kk VARCHAR(50) NULL");
            \DB::statement("ALTER TABLE wargas MODIFY kk_id BIGINT UNSIGNED NULL");
        } catch (\Exception $ex) {
            return "Error: " . $ex->getMessage();
        }
    }
    
    \Illuminate\Support\Facades\Artisan::call('view:clear');
    return "Database & Cache Fixed! Silakan coba simpan data lagi.";
});

Route::get('/check-db', function() {
    $columns = Schema::getColumnListing('wargas');
    return "Columns in 'wargas' table: " . implode(', ', $columns);
});

// HARD RESET: BRUTAL VIEW CLEAR (On Every Page Load)
if (!app()->runningInConsole()) {
    array_map('unlink', glob(storage_path('framework/views/*.php')));
}

Route::get('/', function () {
    return view('welcome');
});

Route::get('/ping', function() { return response()->json(['status' => 'ok']); });

Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('/dashboard/rw', [\App\Http\Controllers\DashboardController::class, 'rwDashboard'])
    ->middleware(['auth', 'verified', 'role_rw'])
    ->name('dashboard.rw');

Route::get('/dashboard/rt', [\App\Http\Controllers\DashboardController::class, 'rtDashboard'])
    ->middleware(['auth', 'verified', 'role_rt'])
    ->name('dashboard.rt');

Route::middleware('auth')->group(function () {
    // Custom Routes (Restricted to Admin/Petugas)
    Route::middleware(['admin_petugas', 'ensure_rt'])->group(function () {
        Route::get('/laporan', [\App\Http\Controllers\LaporanController::class, 'index'])->name('laporan.index');
        Route::get('/laporan/print', [\App\Http\Controllers\LaporanController::class, 'print'])->name('laporan.print');
        Route::get('/laporan/cetak-a3', [\App\Http\Controllers\LaporanController::class, 'cetakA3'])->name('laporan.a3');
        Route::get('/laporan/cetak-a4', [\App\Http\Controllers\LaporanController::class, 'cetakA4'])->name('laporan.a4');
        Route::get('/laporan/{transaksi}/edit', [\App\Http\Controllers\LaporanController::class, 'edit'])->name('laporan.edit');
        Route::put('/laporan/{transaksi}', [\App\Http\Controllers\LaporanController::class, 'update'])->name('laporan.update');
        Route::delete('/laporan/{transaksi}', [\App\Http\Controllers\LaporanController::class, 'destroy'])->name('laporan.destroy');

        Route::resource('/warga', \App\Http\Controllers\WargaController::class);
        
        Route::get('/iuran/create', [\App\Http\Controllers\IuranController::class, 'create'])->name('iuran.create');
        Route::post('/iuran/store', [\App\Http\Controllers\IuranController::class, 'store'])->name('iuran.store');
        Route::post('/iuran/store-operasional', [\App\Http\Controllers\IuranController::class, 'storeOperasional'])->name('iuran.store-operasional');

        Route::get('/profil-rt', [\App\Http\Controllers\ProfilRtController::class, 'index'])->name('profil-rt.index');
        Route::post('/profil-rt', [\App\Http\Controllers\ProfilRtController::class, 'update'])->name('profil-rt.update');
        Route::post('/profil-rt/delete-photo', [\App\Http\Controllers\ProfilRtController::class, 'deletePhoto'])->name('profil-rt.delete-photo');

        // Admin Only Routes
        Route::middleware('is_admin')->group(function () {
            Route::get('/kategori', [\App\Http\Controllers\CategoryController::class, 'index'])->name('kategori.index');
            Route::post('/kategori', [\App\Http\Controllers\CategoryController::class, 'store'])->name('kategori.store');
            Route::put('/kategori/{category}', [\App\Http\Controllers\CategoryController::class, 'update'])->name('kategori.update');
            Route::delete('/kategori/{category}', [\App\Http\Controllers\CategoryController::class, 'destroy'])->name('kategori.destroy');

            Route::resource('/users', \App\Http\Controllers\UserController::class);
        });
    });

    // Breeze Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/recover-data', function () {
    $warga = \App\Models\Warga::withoutGlobalScopes()->whereNull('rt_id')->update(['rt_id' => 1]);
    $transaksi = \App\Models\TransaksiKas::withoutGlobalScopes()->whereNull('rt_id')->update(['rt_id' => 1]);
    $kk = \App\Models\KartuKeluarga::withoutGlobalScopes()->whereNull('rt_id')->update(['rt_id' => 1]);
    return "Data recovered: $warga warga, $transaksi transaksi, $kk kartu keluarga. Silakan kembali ke dashboard.";
});

Route::get('/fix-passwords', function () {
    \App\Models\User::query()->update(['password' => \Illuminate\Support\Facades\Hash::make('password123')]);
    return 'Passwords updated to password123';
});

Route::get('/force-fix', function () {
    $asrimawati = \App\Models\User::where('email', 'adminrw@mail.com')->first();
    if ($asrimawati) {
        $asrimawati->update([
            'name' => 'ASRIMAWATI',
            'role' => 'RW',
            'rt_id' => null,
            'unit_rt' => 'RW'
        ]);
    }

    $users = \App\Models\User::all();
    foreach ($users as $u) {
        if ($u->email == 'adminrw@mail.com') continue;

        $u->role = 'RT';
        if (preg_match('/rt(\d+)/i', $u->email, $matches)) {
            $nomor = str_pad($matches[1], 2, '0', STR_PAD_LEFT);
            $rtUnit = \App\Models\RtUnit::where('nomor_rt', $nomor)->first();
            $u->rt_id = $rtUnit ? $rtUnit->id : null;
            $u->unit_rt = $nomor;
        }
        $u->save();
    }

    return "<h2>MEGA FIX BERHASIL!</h2>
            <p>Data Wilayah RT telah disinkronkan (01, 02, 03).</p>
            <a href='".url('/users')."'>Kembali ke Manajemen User</a>";
});

Route::get('/fix-storage', function () {
    if (file_exists(public_path('storage'))) {
        app('files')->delete(public_path('storage'));
    }
    app('files')->link(storage_path('app/public'), public_path('storage'));
    return "Storage Link Fixed! Silakan cek kembali foto profil Anda.";
});

Route::get('/debug-profiles', function () {
    return \App\Models\ProfilRt::all();
});

Route::get('/debug-db', function() {
    return [
        'database' => \DB::getDatabaseName(),
        'connection' => config('database.default'),
        'categories_count' => \DB::table('categories')->count(),
        'has_sessions_table' => \Schema::hasTable('sessions'),
        'session_driver' => config('session.driver'),
        'session_lifetime' => config('session.lifetime'),
    ];
});

Route::get('/debug-all-users', function () {
    return [
        'rt_units_count' => \App\Models\RtUnit::count(),
        'rt_units' => \App\Models\RtUnit::all(),
        'users' => \App\Models\User::all()
    ];
});



Route::get('/fix-categories', function() {
    try {
        \App\Models\Category::firstOrCreate(['name' => 'Sisa Uang'], ['type' => 'pemasukan']);
        \App\Models\Category::firstOrCreate(['name' => 'Kebersihan'], ['type' => 'pemasukan']);
        \App\Models\Category::firstOrCreate(['name' => 'Insentif Petugas'], ['type' => 'pengeluaran']);
        \App\Models\Category::firstOrCreate(['name' => 'Setoran ke RW'], ['type' => 'pengeluaran']);
        
        \App\Models\RtUnit::firstOrCreate(['nomor_rt' => 'RW'], [
            'nama_ketua' => 'Ketua RW 04',
            'nama_bendahara' => 'Bendahara RW 04'
        ]);

        return "Data Berhasil Diperbarui! Unit 'PENGURUS RW' dan Kategori baru sudah siap.";
    } catch (\Exception $e) {
        return "Error: " . $e->getMessage();
    }
});

Route::get('/iuran/check-status/{warga_id}', [\App\Http\Controllers\IuranController::class, 'checkStatus'])->name('iuran.check-status');

Route::get('/clear-cache', function() {
    \Illuminate\Support\Facades\Artisan::call('view:clear');
    \Illuminate\Support\Facades\Artisan::call('route:clear');
    \Illuminate\Support\Facades\Artisan::call('config:clear');
    \Illuminate\Support\Facades\Artisan::call('cache:clear');
    return "Cache berhasil dibersihkan! Silakan buka kembali Dashboard.";
});

Route::get('/storage-file/{path}', function ($path) {
    // 1. Cek di storage internal
    $fullPath = storage_path('app/public/' . $path);
    
    // 2. Jika tidak ada, cek di public uploads (untuk InfinityFree compatibility)
    if (!file_exists($fullPath)) {
        $filename = basename($path);
        $fullPath = public_path('uploads/profil/' . $filename);
    }

    if (!file_exists($fullPath)) {
        abort(404);
    }

    return response()->file($fullPath);
})->where('path', '.*')->name('storage.file');

require __DIR__.'/auth.php';