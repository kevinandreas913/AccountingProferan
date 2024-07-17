<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RekapDataAkun extends Model
{
    use HasFactory, HasUuids;
    protected $table = 'rekap_data_akun';
    protected $guarded = [''];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function master_jenis_akun()
    {
        return $this->belongsTo(MasterJenisAkun::class);
    }
}
