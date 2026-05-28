<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Xóa bảng cũ
        Schema::dropIfExists('crawl_sources');

        // Tạo lại bảng mới
        Schema::create('crawl_sources', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('url');

            // Chế độ: interval | daily_times | once
            $table->enum('mode', ['interval', 'daily_times', 'once'])
                  ->default('daily_times');

            // Chế độ 1 — Lặp lại mỗi X phút
            $table->integer('interval_minutes')->nullable();

            // Chế độ 2 — Khung giờ hàng ngày (VD: "06:00,12:00,20:00")
            $table->string('daily_times')->nullable();

            // Chế độ 3 — Hẹn 1 lần (ngày giờ cụ thể)
            $table->datetime('run_at')->nullable();

            // Chế độ 1 & 2 — Thời hạn (null = Vô thời hạn)
            $table->datetime('expires_at')->nullable();

            $table->integer('max_posts')->default(5);
            $table->boolean('is_active')->default(true);

            // Chế độ 3 — Đã chạy xong chưa
            $table->boolean('is_done')->default(false);

            $table->timestamp('last_run_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('crawl_sources');
    }
};
