<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToBranch;

class StaffAttendance extends Model
{
    use BelongsToBranch;
    use HasFactory;

    protected $fillable = [
        'staff_id',
        'attendance_date',
        'check_in_time',
        'check_out_time',
        'status',
        'notes',
    ];

    protected $casts = [
        'attendance_date' => 'date',
        'check_in_time' => 'datetime',
        'check_out_time' => 'datetime',
    ];

    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }

    public static function autoCheckout()
    {
        $today = now()->toDateString();
        $currentTime = now()->format('H:i:s');
        
        $staffToCheckout = Staff::whereNotNull('shift_end')
            ->whereHas('attendances', function($q) use ($today) {
                $q->where('attendance_date', $today)
                  ->where('status', 'present')
                  ->whereNull('check_out_time');
            })->get();

        foreach ($staffToCheckout as $s) {
            if ($currentTime > $s->shift_end) {
                $attendance = $s->attendances()->where('attendance_date', $today)->first();
                if ($attendance) {
                    $attendance->update([
                        'check_out_time' => \Carbon\Carbon::createFromFormat('H:i:s', $s->shift_end),
                        'notes' => ($attendance->notes ? $attendance->notes . ' ' : '') . '[System: Auto-checkout at shift end]'
                    ]);
                }
            }
        }
    }

    public function getHoursWorkedAttribute()
    {
        if ($this->check_in_time && $this->check_out_time) {
            return $this->check_out_time->diffInHours($this->check_in_time);
        }
        return 0;
    }
}
