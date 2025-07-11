<?php

// app/Models/Schedule.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Schedule extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['id', 'user_id', 'description', 'start_time', 'end_time', 'meeting_date', 'type'];

    public function attendances() {
        return $this->hasMany(Attendance::class);
    }
}
