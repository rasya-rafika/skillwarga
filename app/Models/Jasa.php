<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\User; // Add this import

class Jasa extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_jasa',
        'deskripsi',
        'kategori',
        'harga',
        'lokasi',
        'kontak',
        'gambar',
        'status',
        'created_by'
    ];

    protected $casts = [
        'harga' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relasi dengan User yang membuat jasa
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Relasi dengan ratings (jika ada sistem rating)
     */
    public function ratings(): HasMany
    {
        return $this->hasMany(Rating::class);
    }

    /**
     * Scope untuk jasa yang aktif
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'aktif');
    }

    /**
     * Scope untuk search berdasarkan nama dan deskripsi
     */
    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('nama_jasa', 'like', "%{$search}%")
              ->orWhere('deskripsi', 'like', "%{$search}%");
        });
    }

    /**
     * Scope untuk filter berdasarkan kategori
     */
    public function scopeByKategori($query, $kategori)
    {
        return $query->where('kategori', $kategori);
    }

    /**
     * Scope untuk filter berdasarkan lokasi
     */
    public function scopeByLokasi($query, $lokasi)
    {
        return $query->where('lokasi', 'like', "%{$lokasi}%");
    }

    /**
     * Accessor untuk format harga
     */
    public function getFormattedHargaAttribute()
    {
        return 'Rp ' . number_format($this->harga, 0, ',', '.');
    }

    /**
     * Accessor untuk URL gambar
     */
    public function getGambarUrlAttribute()
    {
        if ($this->gambar) {
            return asset('storage/' . $this->gambar);
        }
        return asset('images/default-jasa.jpg'); // Default image
    }

    /**
     * Accessor untuk status badge
     */
    public function getStatusBadgeAttribute()
    {
        return $this->status === 'aktif' 
            ? '<span class="px-2 py-1 text-xs bg-green-100 text-green-800 rounded-full">Aktif</span>'
            : '<span class="px-2 py-1 text-xs bg-red-100 text-red-800 rounded-full">Nonaktif</span>';
    }

    /**
     * Static method untuk get semua kategori
     */
    public static function getKategoris()
    {
        return self::distinct()->pluck('kategori')->filter()->sort();
    }

    /**
     * Static method untuk get semua lokasi
     */
    public static function getLokasis()
    {
        return self::distinct()->pluck('lokasi')->filter()->sort();
    }
}