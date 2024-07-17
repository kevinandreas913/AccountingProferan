<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterJenisAkun extends Model
{
    use HasFactory, HasUuids;
    protected $table = 'master_jenis_akun';
    protected $guarded = [''];

    public function master_akun()
    {
        return $this->hasMany(MasterAkun::class);
    }

    public function rekap_data_akun()
    {
        return $this->hasMany(RekapDataAkun::class);
    }
}
