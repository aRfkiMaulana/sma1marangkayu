<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SettingBobotPrestasi extends Model
{
    protected $table = 'setting_bobot_prestasi';

    protected $fillable = ['tingkat', 'bobot'];

    public static function getBobotArray(): array
    {
        return self::pluck('bobot', 'tingkat')->toArray();
    }
}
