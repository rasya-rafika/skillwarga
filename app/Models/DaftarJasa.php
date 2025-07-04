<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DaftarJasa extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'daftar_jasa';

    protected $fillable = [
        'user_id',
        'nama',
        'email',
        'telepon',
        'jenis_jasa',
        'deskripsi',
        'alamat',
        'budget',
        'deadline',
        'foto',
        'catatan',
        'status',
        'is_read',
        'admin_notes'
    ];

    protected $casts = [
        'deadline' => 'date',
        'budget' => 'decimal:2',
        'is_read' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime'
    ];

    // Relationship with User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Scope for unread messages
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    // Scope for specific status
    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    // Accessor for formatted budget
    public function getFormattedBudgetAttribute()
    {
        if ($this->budget) {
            return 'Rp ' . number_format($this->budget, 0, ',', '.');
        }
        return 'Tidak disebutkan';
    }

    // Accessor for status badge class
    public function getStatusBadgeClassAttribute()
    {
        return match($this->status) {
            'pending' => 'bg-yellow-100 text-yellow-800',
            'approved' => 'bg-green-100 text-green-800',
            'rejected' => 'bg-red-100 text-red-800',
            'completed' => 'bg-blue-100 text-blue-800',
            default => 'bg-gray-100 text-gray-800'
        };
    }

    // Accessor for status text
    public function getStatusTextAttribute()
    {
        return match($this->status) {
            'pending' => 'Menunggu',
            'approved' => 'Disetujui',
            'rejected' => 'Ditolak',
            'completed' => 'Selesai',
            default => 'Tidak diketahui'
        };
    }

    // Accessor for photo URL
    public function getPhotoUrlAttribute()
    {
        if ($this->foto) {
            return asset('storage/' . $this->foto);
        }
        return null;
    }

    // Check if has photo
    public function hasPhoto()
    {
        return !empty($this->foto);
    }
}