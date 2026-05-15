<?php

namespace App\Http\Controllers;

use App\Models\Warga;
use App\Models\KartuKeluarga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WargaController extends Controller
{
    public function index()
    {
        $wargas = Warga::with('kartuKeluarga')->latest()->get();
        return view('warga.index', compact('wargas'));
    }

    public function create()
    {
        $rt_units = \App\Models\RtUnit::all();
        return view('warga.create', compact('rt_units'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        $rules = [
            'nama_warga' => 'required|string|max:255',
            'no_telp' => 'nullable|string',
            'jenis_warga' => 'required|in:Pribumi,Pendatang',
            'status' => 'required|in:aktif,pindah,tidak_aktif',
        ];

        // Jika user adalah admin (RW), mereka harus memilih RT
        if ($user->isAdmin() && is_null($user->rt_id)) {
            $rules['rt_id'] = 'required|exists:rt_units,id';
        }

        $request->validate($rules, [
            'rt_id.required' => 'Silakan pilih RT terlebih dahulu.'
        ]);

        $rt_id = ($user->isAdmin() && is_null($user->rt_id)) ? $request->rt_id : $user->rt_id;

        if (is_null($rt_id)) {
            return redirect()->back()->withErrors(['rt_id' => 'Data RT tidak ditemukan. Silakan hubungi admin.'])->withInput();
        }

        // Cari atau buat KK jika no_kk diisi, jika tidak gunakan KK default per RT
        if ($request->filled('no_kk')) {
            $kk = KartuKeluarga::firstOrCreate(
                ['no_kk' => $request->no_kk],
                ['nama_kepala_keluarga' => $request->nama_warga, 'rt_id' => $rt_id]
            );
            $kk_id = $kk->id;
        } else {
            // Gunakan KK dummy unik per RT agar tidak bentrok
            $dummyNoKk = '-RT' . str_pad($rt_id, 2, '0', STR_PAD_LEFT);
            $kk = KartuKeluarga::firstOrCreate(
                ['no_kk' => $dummyNoKk],
                ['nama_kepala_keluarga' => 'Warga Tanpa KK', 'rt_id' => $rt_id]
            );
            $kk_id = $kk->id;
        }

        // Data warga
        $data = $request->only(['nama_warga', 'no_telp', 'jenis_warga', 'status']);
        
        // Buat ID unik otomatis yang pendek agar muat di database (Max 16 karakter)
        $uniqueId = substr(time(), -7) . rand(100, 999);
        $data['nik'] = 'N' . $uniqueId;
        $data['no_kk'] = 'K' . $uniqueId;
        
        $data['kk_id'] = $kk_id;
        $data['rt_id'] = $rt_id;
        $data['status'] = strtolower($request->status);
        $data['jenis_warga'] = $request->jenis_warga ?: 'Pribumi'; // Default jika kosong
        $data['is_active'] = $data['status'] === 'aktif';
        $data['tgl_masuk_warga'] = $request->tgl_masuk_warga; // Boleh NULL, nanti di model default ke Jan 2026
        
        if ($data['status'] !== 'aktif') {
            $data['tgl_keluar_warga'] = now();
        }

        Warga::create($data);

        return redirect()->back()->with('success', 'Data warga berhasil disimpan!');
    }

    public function edit(Warga $warga)
    {
        $rt_units = \App\Models\RtUnit::all();
        return view('warga.edit', compact('warga', 'rt_units'));
    }

    public function update(Request $request, Warga $warga)
    {
        $request->validate([
            'nama_warga' => 'required|string|max:255',
            'no_telp' => 'nullable|string',
            'jenis_warga' => 'required|in:Pribumi,Pendatang',
            'status' => 'required|in:aktif,pindah,tidak_aktif',
        ]);

        // Simpan data dasar
        $data = $request->only([
            'nama_warga', 'no_telp', 'jenis_warga', 'status'
        ]);
        
        // Tetap gunakan data lama atau buatkan ID unik pendek jika kosong
        $uniqueId = substr(time(), -7) . rand(100, 999);
        $data['nik'] = $warga->nik ?: 'N' . $uniqueId;
        $data['no_kk'] = $warga->no_kk ?: 'K' . $uniqueId;
        $data['status'] = strtolower($request->status);
        $data['is_active'] = $data['status'] === 'aktif';
        $data['tgl_masuk_warga'] = $request->tgl_masuk_warga; // Boleh NULL
        
        if ($request->filled('no_kk')) {
            $kk = KartuKeluarga::firstOrCreate(
                ['no_kk' => $request->no_kk],
                ['nama_kepala_keluarga' => $request->nama_warga, 'rt_id' => $warga->rt_id]
            );
            $data['kk_id'] = $kk->id;
        } else if (!$warga->kk_id) {
            $dummyNoKk = '-RT' . str_pad($warga->rt_id, 2, '0', STR_PAD_LEFT);
            $kk = KartuKeluarga::firstOrCreate(
                ['no_kk' => $dummyNoKk],
                ['nama_kepala_keluarga' => 'Warga Tanpa KK', 'rt_id' => $warga->rt_id]
            );
            $data['kk_id'] = $kk->id;
        }

        $warga->update($data);

        return redirect()->route('warga.index')->with('status', 'Data warga berhasil diperbarui!');
    }

    public function destroy(Warga $warga)
    {
        // Cek apakah warga memiliki riwayat transaksi
        $transactionCount = $warga->transaksiKas()->count();

        if ($transactionCount > 0) {
            return redirect()->back()->with('error', "Gagal menghapus! Warga ini memiliki $transactionCount riwayat transaksi. Silakan ubah status menjadi 'Pindah' atau 'Tidak Aktif' sebagai gantinya.");
        }

        $warga->delete();
        return redirect()->route('warga.index')->with('status', 'Data warga berhasil dihapus!');
    }
}
