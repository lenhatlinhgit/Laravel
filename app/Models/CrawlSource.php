<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class CrawlSource extends Model
{
    protected $fillable = [
        'name',
        'url',
        'mode',
        'interval_minutes',
        'daily_times',
        'run_at',
        'expires_at',
        'max_posts',
        'is_active',
        'is_done',
        'last_run_at',
    ];

    protected $casts = [
        'is_active'   => 'boolean',
        'is_done'     => 'boolean',
        'run_at'      => 'datetime',
        'expires_at'  => 'datetime',
        'last_run_at' => 'datetime',
    ];

    // ================================
    // Kiểm tra đã đến giờ chạy chưa
    // ================================
    public function isDue(): bool
    {
        // Chế độ once đã chạy rồi → bỏ qua
        if ($this->is_done) {
            return false;
        }

        // Đã hết hạn (chế độ 1 & 2) → bỏ qua
        if ($this->expires_at && now()->isAfter($this->expires_at)) {
            return false;
        }

        return match ($this->mode) {
            'interval'    => $this->isDueInterval(),
            'daily_times' => $this->isDueDailyTimes(),
            'once'        => $this->isDueOnce(),
            default       => false,
        };
    }

    // Chế độ 1 — Lặp lại mỗi X phút
    private function isDueInterval(): bool
    {
        if (!$this->interval_minutes) {
            return false;
        }

        if (!$this->last_run_at) {
            return true;
        }

        return $this->last_run_at->diffInMinutes(now()) >= $this->interval_minutes;
    }

    // Chế độ 2 — Khung giờ hàng ngày
    private function isDueDailyTimes(): bool
    {
        if (!$this->daily_times) {
            return false;
        }

        $times = explode(',', $this->daily_times);
        $now   = now();

        foreach ($times as $time) {

            $time = trim($time);

            $scheduled = Carbon::createFromFormat(
                'Y-m-d H:i',
                $now->format('Y-m-d') . ' ' . $time
            );

            // Chưa đến giờ hoặc đã qua hơn 1 phút → bỏ qua khung này
            if ($now->lt($scheduled) || $now->diffInMinutes($scheduled) > 1) {
                continue;
            }

            // Đã chạy trong khung giờ này hôm nay rồi → bỏ qua
            if (
                $this->last_run_at &&
                $this->last_run_at->isToday() &&
                abs($this->last_run_at->diffInMinutes($scheduled)) <= 1
            ) {
                continue;
            }

            return true;
        }

        return false;
    }

    // Chế độ 3 — Hẹn 1 lần
    private function isDueOnce(): bool
    {
        if (!$this->run_at) {
            return false;
        }

        // Đến giờ hẹn, cho phép trễ tối đa 1 phút
        return now()->gte($this->run_at) &&
               now()->diffInMinutes($this->run_at) <= 1;
    }
}
