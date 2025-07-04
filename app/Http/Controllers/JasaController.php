<?php

namespace App\Http\Controllers;

use App\Models\Jasa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class JasaController extends Controller
{
    public function index()
    {
        $jasas = Jasa::latest()->paginate(10);
        
        // Tambahkan kategoris dan lokasis untuk view yang membutuhkan
        $kategoris = $this->getKategoris();
        $lokasis = $this->getLokasis();
        
        return view('cari_jasa.index', compact('jasas', 'kategoris', 'lokasis'));
    }

    public function create()
    {
        // Siapkan data untuk dropdown/select
        $kategoris = $this->getKategoris();
        $lokasis = $this->getLokasis();
        
        return view('cari_jasa.create', compact('kategoris', 'lokasis'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'nama_jasa' => 'required|string|max:255',
                'deskripsi' => 'required|string',
                'kategori' => 'required|string',
                'harga' => 'required|numeric|min:0',
                'lokasi' => 'required|string|max:255',
                'kontak' => 'required|string|max:255',
                'gambar' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:2048',
                'status' => 'required|in:aktif,nonaktif'
            ]);

            // Handle upload gambar
            if ($request->hasFile('gambar')) {
                $gambarPath = $request->file('gambar')->store('jasa', 'public');
                $validated['gambar'] = $gambarPath;
            }

            // Tambahkan created_by - pastikan user sudah login
            if (auth()->check()) {
                $validated['created_by'] = auth()->id();
            } else {
                return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu');
            }

            // Simpan ke database
            $jasa = Jasa::create($validated);

            return redirect()->route('jasa.index')->with('success', 'Jasa berhasil ditambahkan!');
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
            
        } catch (\Exception $e) {
            Log::error('Jasa creation error:', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            return back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()])->withInput();
        }
    }

    public function show(Jasa $jasa)
    {
        return view('cari_jasa.show', compact('jasa'));
    }

    public function edit(Jasa $jasa)
    {
        // Siapkan data untuk dropdown/select
        $kategoris = $this->getKategoris();
        $lokasis = $this->getLokasis();
        
        return view('cari_jasa.edit', compact('jasa', 'kategoris', 'lokasis'));
    }

    public function update(Request $request, Jasa $jasa)
    {
        try {
            $validated = $request->validate([
                'nama_jasa' => 'required|string|max:255',
                'deskripsi' => 'required|string',
                'kategori' => 'required|string',
                'harga' => 'required|numeric|min:0',
                'lokasi' => 'required|string|max:255',
                'kontak' => 'required|string|max:255',
                'gambar' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:2048',
                'status' => 'required|in:aktif,nonaktif'
            ]);

            // Handle upload gambar baru
            if ($request->hasFile('gambar')) {
                // Hapus gambar lama jika ada
                if ($jasa->gambar) {
                    Storage::disk('public')->delete($jasa->gambar);
                }
                $validated['gambar'] = $request->file('gambar')->store('jasa', 'public');
            }

            $jasa->update($validated);
            return redirect()->route('jasa.index')->with('success', 'Jasa berhasil diupdate!');
            
        } catch (\Exception $e) {
            Log::error('Jasa update error:', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            return back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()])->withInput();
        }
    }

    public function destroy(Jasa $jasa)
    {
        try {
            // Hapus gambar jika ada
            if ($jasa->gambar) {
                Storage::disk('public')->delete($jasa->gambar);
            }
            $jasa->delete();
            return redirect()->route('jasa.index')->with('success', 'Jasa berhasil dihapus!');
            
        } catch (\Exception $e) {
            Log::error('Jasa delete error:', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            return back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    public function toggleStatus(Jasa $jasa)
    {
        try {
            $jasa->update([
                'status' => $jasa->status === 'aktif' ? 'nonaktif' : 'aktif'
            ]);
            return back()->with('success', 'Status jasa berhasil diubah!');
            
        } catch (\Exception $e) {
            Log::error('Toggle status error:', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            return back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    /**
     * Get list of categories - sesuaikan dengan form asli
     */
    private function getKategoris()
    {
        return [
            'Teknologi',
            'Rumah Tangga', 
            'Pendidikan',
            'Kesehatan',
            'Kecantikan',
            'Transportasi',
            'Otomotif',
            'Makanan',
            'Olahraga',
            'Lainnya'
        ];
    }

    /**
     * Get list of locations
     */
    private function getLokasis()
    {
        return [
            'Jakarta Pusat',
            'Jakarta Utara',
            'Jakarta Selatan',
            'Jakarta Barat',
            'Jakarta Timur',
            'Bogor',
            'Depok',
            'Tangerang',
            'Bekasi'
        ];
    }
}