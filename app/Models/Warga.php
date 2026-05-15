<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Scopes\RtIsolationScope;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\SoftDeletes;

#[ScopedBy([RtIsolationScope::class])]
class Warga extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'kk_id',
        'rt_id',
        'nik',
        'no_kk',
        'nama_warga',
        'jenis_warga', // Pengganti kolom status lama (Pribumi/Pendatang)
        'status',      // Kolom status baru (aktif, pindah, tidak_aktif)
        'tgl_masuk_warga',
        'tgl_keluar_warga',
        'no_telp',
        'is_active',
        'last_edited_by',
    ];

    protected static function booted()
    {
        static::creating(function ($model) {
            if (auth()->check()) {
                $model->last_edited_by = auth()->user()->name;
                // Otomatis isi rt_id jika belum ada
                if (!$model->rt_id && auth()->user()->rt_id) {
                    $model->rt_id = auth()->user()->rt_id;
                }
            }
        });

        static::updating(function ($model) {
            if (auth()->check()) {
                $model->last_edited_by = auth()->user()->name;
            }
        });
    }
    
    protected $casts = [
        'is_active' => 'boolean',
        'tgl_masuk_warga' => 'date',
        'tgl_keluar_warga' => 'date'
    ];

    public function kartuKeluarga() {
        return $this->belongsTo(KartuKeluarga::class, 'kk_id');
    }

    public function rtUnit() {
        return $this->belongsTo(RtUnit::class, 'rt_id');
    }

    public function transaksiKas() {
        return $this->hasMany(TransaksiKas::class, 'warga_id');
    }

    /**
     * Logic Helper: Nominal Iuran otomatis.
     */
    public function getNominalIuranAttribute(): int
    {
        return $this->jenis_warga === 'Pendatang' ? 5000 : 3000;
    }

    /**
     * Logic Helper: Nama Iuran (IWK/Andon).
     */
    public function getJenisIuranAttribute(): string
    {
        return $this->jenis_warga === 'Pendatang' ? 'Andon' : 'IWK';
    }

    /**
     * Logic Helper: Hitung Tunggakan Iuran.
     */
    public function getTunggakanAttribute(): int
    {
        // Asumsi hitungan dimulai dari Januari 2026 atau tanggal masuk
        $startDate = $this->tgl_masuk_warga ? $this->tgl_masuk_warga->startOfMonth() : \Carbon\Carbon::create(2026, 1, 1);
        
        // Jika warga sudah pindah/tidak aktif, gunakan tanggal keluar sebagai batas hitungan
        $endDate = ($this->status !== 'aktif' && $this->tgl_keluar_warga) 
            ? $this->tgl_keluar_warga->startOfMonth() 
            : now()->startOfMonth();
            
        // Jika warga pindah sebelum sistem mulai (Jan 2026), tunggakan 0
        if ($endDate->lt($startDate)) {
            return 0;
        }
        
        $monthsToPay = $startDate->diffInMonths($endDate) + 1;
        $totalObligation = $monthsToPay * $this->nominal_iuran;
        
        $totalPaid = $this->transaksiKas()
            ->where('jenis_transaksi', 'Masuk')
            ->whereHas('category', function($q) {
                $q->where('name', 'like', '%IWK%')
                  ->orWhere('name', 'like', '%Andon%');
            })
            ->sum('jumlah');
            
        return max(0, $totalObligation - (int)$totalPaid);
    }
}
