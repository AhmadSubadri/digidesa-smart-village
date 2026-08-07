<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Categories table (for articles)
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('icon')->nullable();
            $table->string('color')->nullable();
            $table->foreignId('parent_id')->nullable()->constrained('categories')->nullOnDelete();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Articles table (Berita & Informasi)
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('excerpt')->nullable();
            $table->longText('content');
            $table->string('featured_image')->nullable();
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('author_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('published_at')->nullable();
            $table->enum('status', ['draft', 'review', 'published', 'archived'])->default('draft');
            $table->unsignedInteger('view_count')->default(0);
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_headline')->default(false);
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->integer('reading_time')->nullable(); // in minutes
            $table->string('source')->nullable();
            $table->timestamps();
        });

        // Events table (Agenda Kegiatan)
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->longText('description')->nullable();
            $table->string('location')->nullable();
            $table->datetime('start_datetime');
            $table->datetime('end_datetime')->nullable();
            $table->string('organizer')->nullable();
            $table->string('contact_person')->nullable();
            $table->string('contact_phone')->nullable();
            $table->string('image')->nullable();
            $table->enum('status', ['upcoming', 'ongoing', 'completed', 'cancelled'])->default('upcoming');
            $table->boolean('is_recurring')->default(false);
            $table->string('recurrence_rule')->nullable();
            $table->integer('attendees_count')->default(0);
            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });

        // Announcements table (Pengumuman)
        Schema::create('announcements', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->longText('content');
            $table->enum('priority', ['normal', 'important', 'urgent'])->default('normal');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('attachment_path')->nullable();
            $table->boolean('is_popup')->default(false);
            $table->boolean('is_pinned')->default(false);
            $table->boolean('is_ticker')->default(false); // for running text
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Albums table (Galeri)
        Schema::create('albums', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('cover_image_path')->nullable();
            $table->enum('category', ['kegiatan', 'pembangunan', 'sosial', 'pemerintahan', 'lainnya'])->default('kegiatan');
            $table->date('event_date')->nullable();
            $table->string('photographer')->nullable();
            $table->boolean('is_published')->default(true);
            $table->integer('sort_order')->default(0);
            $table->unsignedInteger('view_count')->default(0);
            $table->timestamps();
        });

        // Media table (for albums and other content)
        Schema::create('media_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('album_id')->nullable()->constrained('albums')->nullOnDelete();
            $table->nullableMorphs('mediable'); // polymorphic
            $table->string('file_path');
            $table->string('file_name');
            $table->enum('file_type', ['image', 'video', 'document'])->default('image');
            $table->string('mime_type')->nullable();
            $table->unsignedBigInteger('file_size')->nullable(); // in bytes
            $table->string('title')->nullable();
            $table->text('caption')->nullable();
            $table->string('alt_text')->nullable();
            $table->integer('width')->nullable();
            $table->integer('height')->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        // Public documents table (PPID)
        Schema::create('public_documents', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->enum('category', ['produk_hukum', 'peraturan_kalurahan', 'sk_lurah', 'laporan_keuangan', 'rkp_kalurahan', 'laporan_bpkal', 'lppd', 'profil_kalurahan', 'data_statistik', 'lainnya']);
            $table->text('description')->nullable();
            $table->string('file_path');
            $table->unsignedBigInteger('file_size')->nullable();
            $table->string('file_type')->nullable();
            $table->year('fiscal_year')->nullable();
            $table->foreignId('uploaded_by')->nullable()->constrained('users')->nullOnDelete();
            $table->boolean('is_published')->default(true);
            $table->unsignedInteger('download_count')->default(0);
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('public_documents');
        Schema::dropIfExists('media_files');
        Schema::dropIfExists('albums');
        Schema::dropIfExists('announcements');
        Schema::dropIfExists('events');
        Schema::dropIfExists('articles');
        Schema::dropIfExists('categories');
    }
};
