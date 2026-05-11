<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToBranch;

class Staff extends Model
{
    use BelongsToBranch;
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'position',
        'hourly_rate',
        'base_salary',
        'commission_per_customer',
        'commission_per_service',
        'total_earned_commission',
        'hiring_date',
        'status',
        'current_shift',
        'shift_start',
        'shift_end',
        'bio',
        'staff_role_id',
        'rating',
        'rating_total',
        'rating_count',
    ];

    protected $casts = [
        'name' => \App\Casts\FlexibleEncryption::class,
        'email' => \App\Casts\FlexibleEncryption::class,
        'phone' => \App\Casts\FlexibleEncryption::class,
        'hourly_rate' => 'decimal:2',
        'base_salary' => 'decimal:2',
        'commission_per_customer' => 'decimal:2',
        'commission_per_service' => 'decimal:2',
        'total_earned_commission' => 'decimal:2',
        'hiring_date' => 'date',
        'status' => 'boolean',
        'rating' => 'integer',
        'rating_total' => 'integer',
        'rating_count' => 'integer',
    ];

    public function getIsOnShiftAttribute()
    {
        if (!$this->shift_start || !$this->shift_end) return false;
        
        $now = now();
        $currentTime = $now->format('H:i:s');
        
        if ($this->shift_start <= $this->shift_end) {
            return ($currentTime >= $this->shift_start && $currentTime <= $this->shift_end);
        } else {
            // Overnight shift (e.g. 22:00 to 02:00)
            return ($currentTime >= $this->shift_start || $currentTime <= $this->shift_end);
        }
    }

    public function getIsPresentTodayAttribute()
    {
        $today = now()->toDateString();
        return $this->attendances()->where('attendance_date', $today)->where('status', 'present')->exists();
    }

    public function scopeAvailable($query)
    {
        $today = now()->toDateString();
        return $query->whereHas('attendances', function($q) use ($today) {
            $q->where('attendance_date', $today)->where('status', 'present');
        });
    }

    public function getAverageRatingAttribute()
    {
        if ($this->rating_count == 0) return 0;
        return round($this->rating_total / $this->rating_count, 1);
    }

    public function attendances()
    {
        return $this->hasMany(StaffAttendance::class);
    }

    public function shifts()
    {
        return $this->hasMany(StaffShift::class);
    }

    public function leaveRequests()
    {
        return $this->hasMany(LeaveRequest::class);
    }

    public function upsellPerformance()
    {
        return $this->hasOne(UpsellPerformance::class);
    }

    public function services()
    {
        return $this->belongsToMany(Service::class, 'staff_service');
    }

    public function role()
    {
        return $this->belongsTo(StaffRole::class, 'staff_role_id');
    }
}
