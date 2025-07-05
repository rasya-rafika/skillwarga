<?php

namespace App\Http\Controllers;

use App\Models\DaftarJasa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class DaftarJasaController extends Controller
{
    /**
     * Get available categories for services
     */
    private function getKategoris()
    {
        return [
            'Teknologi',
            'Desain',
            'Penulisan',
            'Pemasaran',
            'Konsultasi',
            'Pendidikan',
            'Kesehatan',
            'Keuangan',
            'Hukum',
            'Konstruksi',
            'Otomotif',
            'Kebersihan',
            'Catering',
            'Fotografi',
            'Musik',
            'Olahraga',
            'Kecantikan',
            'Perbaikan',
            'Logistik',
            'Lainnya'
        ];
    }

    public function index()
    {
        // Log untuk debugging
        Log::info('DaftarJasaController@index dipanggil');
        Log::info('User role: ' . (auth()->user()->hasRole('admin') ? 'admin' : (auth()->user()->hasRole('user') ? 'user' : 'unknown')));
        
        // Get categories for the form
        $kategoris = $this->getKategoris();
        
        if (auth()->user()->hasRole('admin')) {
            // Admin melihat daftar semua jasa
            $jasas = DaftarJasa::latest()->get();
            Log::info('Admin accessing daftar_jasa.index with ' . $jasas->count() . ' items');
            return view('daftar_jasa.index', compact('jasas', 'kategoris'));
        } elseif (auth()->user()->hasRole('user')) {
            // User melihat form daftar jasa (atau daftar kosong untuk form)
            Log::info('User accessing daftar_jasa.index');
            $jasas = collect(); // Empty collection untuk user
            return view('daftar_jasa.index', compact('jasas', 'kategoris'));
        }
        
        // Kalau bukan admin atau user, baru redirect ke dashboard
        return redirect()->route('dashboard')->with('error', 'Akses ditolak.');
    }

    /**
     * Admin index - khusus untuk admin melalui prefix admin
     */
    public function adminIndex()
    {
        Log::info('DaftarJasaController@adminIndex dipanggil');
        
        if (!auth()->user()->hasRole('admin')) {
            return redirect()->route('dashboard')->with('error', 'Akses ditolak.');
        }

        $jasas = DaftarJasa::latest()->get();
        $kategoris = $this->getKategoris();
        Log::info('Admin accessing admin.daftar_jasa.index with ' . $jasas->count() . ' items');
        return view('daftar_jasa.index', compact('jasas', 'kategoris'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Log::info('DaftarJasaController@store dipanggil');
        
        // Pastikan hanya user yang dapat mengirim pesan
        if (!auth()->user()->hasRole('user')) {
            return redirect()->route('dashboard')->with('error', 'Akses ditolak.');
        }

        try {
            $request->validate([
                'nama_jasa' => 'required|string|max:255',
                'deskripsi' => 'required|string',
                'kategori' => 'required|string|max:255|in:' . implode(',', $this->getKategoris()),
                'harga' => 'required|numeric|min:0',
                'lokasi' => 'required|string|max:255',
                'kontak' => 'required|string|max:255',
                'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            ]);

            $data = $request->only(['nama_jasa', 'deskripsi', 'kategori', 'harga', 'lokasi', 'kontak']);
            $data['user_id'] = auth()->id();
            
            if ($request->hasFile('gambar')) {
                $data['gambar'] = $request->file('gambar')->store('daftar_jasa-gambars', 'public');
            }

            DaftarJasa::create($data);
            Log::info('DaftarJasa created successfully');

            return redirect()->route('daftar_jasa.index')
                             ->with('success', 'Jasa berhasil diajukan!');
        } catch (\Exception $e) {
            Log::error('Error in DaftarJasaController@store: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(DaftarJasa $daftar_jasa)
    {
        if (!auth()->user()->hasRole('admin')) {
            return redirect()->route('dashboard')->with('error', 'Akses ditolak.');
        }

        // Mark as read when viewed
        if (!$daftar_jasa->is_read) {
            $daftar_jasa->update(['is_read' => true]);
        }

        return view('daftar_jasa.show', compact('daftar_jasa'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DaftarJasa $daftar_jasa)
    {
        if (!auth()->user()->hasRole('admin')) {
            return redirect()->route('dashboard')->with('error', 'Akses ditolak.');
        }

        $kategoris = $this->getKategoris();
        return view('daftar_jasa.edit', compact('daftar_jasa', 'kategoris'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DaftarJasa $daftar_jasa)
    {
        if (!auth()->user()->hasRole('admin')) {
            return redirect()->route('dashboard')->with('error', 'Akses ditolak.');
        }

        try {
            $request->validate([
                'nama_jasa' => 'required|string|max:255',
                'deskripsi' => 'required|string',
                'kategori' => 'required|string|max:255|in:' . implode(',', $this->getKategoris()),
                'harga' => 'required|numeric|min:0',
                'lokasi' => 'required|string|max:255',
                'kontak' => 'required|string|max:255',
                'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            ]);

            $data = $request->only(['nama_jasa', 'deskripsi', 'kategori', 'harga', 'lokasi', 'kontak']);
            
            if ($request->hasFile('gambar')) {
                // Delete old photo if exists
                if ($daftar_jasa->gambar) {
                    Storage::disk('public')->delete($daftar_jasa->gambar);
                }
                $data['gambar'] = $request->file('gambar')->store('daftar_jasa-gambars', 'public');
            }

            $daftar_jasa->update($data);

            return redirect()->route('daftar_jasa.index')
                             ->with('success', 'Jasa berhasil diperbarui!');
        } catch (\Exception $e) {
            Log::error('Error in DaftarJasaController@update: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DaftarJasa $daftar_jasa)
    {
        if (!auth()->user()->hasRole('admin')) {
            return redirect()->route('dashboard')->with('error', 'Akses ditolak.');
        }

        try {
            // Delete photo if exists
            if ($daftar_jasa->gambar) {
                Storage::disk('public')->delete($daftar_jasa->gambar);
            }

            $daftar_jasa->delete();

            return redirect()->route('daftar_jasa.index')
                             ->with('success', 'Jasa berhasil dihapus!');
        } catch (\Exception $e) {
            Log::error('Error in DaftarJasaController@destroy: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function markAsRead(DaftarJasa $daftar_jasa)
    {
        if (!auth()->user()->hasRole('admin')) {
            return redirect()->route('dashboard')->with('error', 'Akses ditolak.');
        }

        $daftar_jasa->update(['is_read' => true]);

        return redirect()->route('daftar_jasa.index')
                         ->with('success', 'Jasa telah ditandai sebagai sudah dibaca!');
    }

    public function destroyGambar(DaftarJasa $daftar_jasa)
    {
        if (!auth()->user()->hasRole('admin')) {
            return redirect()->route('dashboard')->with('error', 'Akses ditolak.');
        }

        if ($daftar_jasa->gambar) {
            Storage::disk('public')->delete($daftar_jasa->gambar);
            $daftar_jasa->update(['gambar' => null]);
        }

        return redirect()->back()
                         ->with('success', 'Gambar berhasil dihapus!');
    }
}