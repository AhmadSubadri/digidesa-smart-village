<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('banners', function (Blueprint $table) {
            $table->string('media_type')->default('image')->after('subtitle'); // 'image', 'video', 'youtube'
            $table->string('video_url')->nullable()->after('image_path');
            $table->string('video_path')->nullable()->after('video_url');
            $table->string('image_path')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('banners', function (Blueprint $table) {
            $table->dropColumn(['media_type', 'video_url', 'video_path']);
        });
    }
};
