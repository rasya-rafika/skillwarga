<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
// use App\Models\Jasa; // Uncomment setelah model dibuat

class JasaController extends Controller
{
    // ✅ Halaman daftar dokter (untuk user & admin)
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    $lokasi = $request->get('lokasi');

    $jasa = Jasa::with('ratings') // ubah ini jadi model, bukan controller
        ->when($lokasi, fn($q) => $q->where('lokasi', $lokasi))
        ->get();

    $lokasiList = Jasa::select('lokasi')->distinct()->pluck('lokasi');

    return view('cari_jasa.index', compact('jasa', 'lokasiList', 'lokasi'));
}


    /**
     * Show the form for creating a new resource.
     * Hanya admin yang bisa akses (sudah di-middleware di route)
     */
    public function create()
    {
        // Cek apakah user adalah admin (sesuaikan dengan sistem role Anda)
        // if (!Auth::user()->hasRole('admin')) {
        //     abort(403, 'Unauthorized action.');
        // }

        return view('cari_jasa.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'nama_jasa' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'kategori' => 'required|string|max:100',
            'harga' => 'required|numeric|min:0',
            'lokasi' => 'required|string|max:255',
            'kontak' => 'required|string|max:50',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:aktif,nonaktif'
        ]);

        // Handle upload gambar
        $gambarPath = null;
        if ($request->hasFile('gambar')) {
            $gambarPath = $request->file('gambar')->store('jasa-images', 'public');
        }

        // Simpan data jasa (uncomment setelah model dibuat)
        // $jasa = Jasa::create([
        //     'nama_jasa' => $validated['nama_jasa'],
        //     'deskripsi' => $validated['deskripsi'],
        //     'kategori' => $validated['kategori'],
        //     'harga' => $validated['harga'],
        //     'lokasi' => $validated['lokasi'],
        //     'kontak' => $validated['kontak'],
        //     'gambar' => $gambarPath,
        //     'status' => $validated['status'],
        //     'created_by' => Auth::id()
        // ]);

        return redirect()->route('cari_jasa.index')
            ->with('success', 'Jasa berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // $jasa = Jasa::findOrFail($id);
        
        return view('cari_jasa.show'); // , compact('jasa')
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Cek apakah user adalah admin (sesuaikan dengan sistem role Anda)
        // if (!Auth::user()->hasRole('admin')) {
        //     abort(403, 'Unauthorized action.');
        // }

        // $jasa = Jasa::findOrFail($id);
        
        return view('cari_jasa.edit'); // , compact('jasa')
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Cek apakah user adalah admin (sesuaikan dengan sistem role Anda)
        // if (!Auth::user()->hasRole('admin')) {
        //     abort(403, 'Unauthorized action.');
        // }

        // $jasa = Jasa::findOrFail($id);

        // Validasi input
        $validated = $request->validate([
            'nama_jasa' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'kategori' => 'required|string|max:100',
            'harga' => 'required|numeric|min:0',
            'lokasi' => 'required|string|max:255',
            'kontak' => 'required|string|max:50',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:aktif,nonaktif'
        ]);

        // Handle upload gambar baru
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            // if ($jasa->gambar) {
            //     Storage::disk('public')->delete($jasa->gambar);
            // }
            
            $validated['gambar'] = $request->file('gambar')->store('jasa-images', 'public');
        }

        // Update data (uncomment setelah model dibuat)
        // $jasa->update($validated);

        return redirect()->route('cari_jasa.index')
            ->with('success', 'Jasa berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Cek apakah user adalah admin (sesuaikan dengan sistem role Anda)
        // if (!Auth::user()->hasRole('admin')) {
        //     abort(403, 'Unauthorized action.');
        // }

        // $jasa = Jasa::findOrFail($id);

        // Hapus gambar jika ada
        // if ($jasa->gambar) {
        //     Storage::disk('public')->delete($jasa->gambar);
        // }

        // Hapus data jasa
        // $jasa->delete();

        return redirect()->route('cari_jasa.index')
            ->with('success', 'Jasa berhasil dihapus!');
    }

    /**
     * Method tambahan untuk mencari jasa
     */
    public function search(Request $request)
    {
        $query = $request->get('q');
        $kategori = $request->get('kategori');
        $lokasi = $request->get('lokasi');

        // Uncomment setelah model dibuat
        // $jasas = Jasa::where('status', 'aktif')
        //     ->when($query, function ($q) use ($query) {
        //         return $q->where('nama_jasa', 'like', "%{$query}%")
        //                 ->orWhere('deskripsi', 'like', "%{$query}%");
        //     })
        //     ->when($kategori, function ($q) use ($kategori) {
        //         return $q->where('kategori', $kategori);
        //     })
        //     ->when($lokasi, function ($q) use ($lokasi) {
        //         return $q->where('lokasi', 'like', "%{$lokasi}%");
        //     })
        //     ->latest()
        //     ->paginate(10);

        return view('cari_jasa.index'); // , compact('jasas')
    }

    /**
     * Method untuk toggle status jasa
     */
    public function toggleStatus(string $id)
    {
        // Cek apakah user adalah admin (sesuaikan dengan sistem role Anda)
        // if (!Auth::user()->hasRole('admin')) {
        //     abort(403, 'Unauthorized action.');
        // }

        // $jasa = Jasa::findOrFail($id);
        // $jasa->status = $jasa->status === 'aktif' ? 'nonaktif' : 'aktif';
        // $jasa->save();

        return redirect()->back()
            ->with('success', 'Status jasa berhasil diubah!');
    }
}