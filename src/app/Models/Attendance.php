<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\BreakTime;
use App\Models\CorrectionRequest;
use Carbon\Carbon;

class Attendance extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'work_date',
        'clock_in',
        'clock_out',
        'break_start',
        'break_end',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function breakTimes()
    {
        return $this->hasMany(BreakTime::class);
    }

    public function correctionRequests()
    {
        return $this->hasMany(CorrectionRequest::class);
    }

    public function getWorkTimeAttribute()
    {
    if (!$this->clock_in || !$this->clock_out) {
        return null;
    }

    $start = Carbon::parse($this->clock_in);
    $end   = Carbon::parse($this->clock_out);

    $workMinutes = $end->diffInMinutes($start);

    if ($this->break_start && $this->break_end) {
        $breakStart = Carbon::parse($this->break_start);
        $breakEnd   = Carbon::parse($this->break_end);

        $breakMinutes = $breakEnd->diffInMinutes($breakStart);
        $workMinutes -= $breakMinutes;
    }
    $workMinutes = max($workMinutes, 0);

    return floor($workMinutes / 60) . '時間' . ($workMinutes % 60) . '分';
    }
}

