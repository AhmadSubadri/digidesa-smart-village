<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Letter types table (Jenis Surat)
        Schema::create('letter_types', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->text('description')->nullable();
            $table->json('requirements')->nullable(); // [{label, type, required}]
            $table->string('template_path')->nullable(); // Blade template
            $table->boolean('is_active')->default(true);
            $table->integer('estimated_days')->default(1);
            $table->decimal('fee', 10, 2)->default(0);
            $table->boolean('needs_approval')->default(true);
            $table->enum('approval_level', ['operator', 'sekretaris', 'lurah'])->default('lurah');
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        // Letter requests table (Permohonan Surat)
        Schema::create('letter_requests', function (Blueprint $table) {
            $table->id();
            $table->string('request_number')->unique(); // REQ-YYYYMMDD-XXXX
            $table->foreignId('resident_id')->nullable()->constrained('residents')->nullOnDelete();
            $table->foreignId('warga_user_id')->nullable()->constrained('warga_users')->nullOnDelete();
            $table->foreignId('letter_type_id')->constrained()->cascadeOnDelete();
            $table->enum('status', [
                'submitted', 'verifying', 'revision', 'processing',
                'waiting_signature', 'completed', 'rejected', 'cancelled'
            ])->default('submitted');
            $table->json('form_data')->nullable();
            $table->json('attachments')->nullable();
            $table->text('notes')->nullable();
            $table->text('rejection_reason')->nullable();
            $table->foreignId('verified_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('verified_at')->nullable();
            $table->foreignId('processed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('processed_at')->nullable();
            $table->foreignId('signed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('signed_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->string('pdf_path')->nullable();
            $table->string('qr_code_token')->unique()->nullable();
            $table->string('signature_image_path')->nullable();
            $table->string('letter_number')->nullable(); // nomor surat resmi
            $table->timestamps();
        });

        // Letter logs table (tracking history)
        Schema::create('letter_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('letter_request_id')->constrained()->cascadeOnDelete();
            $table->string('action');
            $table->foreignId('performed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->text('notes')->nullable();
            $table->string('old_status')->nullable();
            $table->string('new_status')->nullable();
            $table->timestamp('created_at')->useCurrent();
        });

        // Complaints table (Pengaduan & Aspirasi)
        Schema::create('complaints', function (Blueprint $table) {
            $table->id();
            $table->string('ticket_number')->unique(); // ADU-YYYYMMDD-XXXX
            $table->string('name');
            $table->text('nik')->nullable(); // encrypted
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->enum('category', ['infrastruktur', 'pelayanan_publik', 'keamanan', 'kebersihan', 'sosial', 'lainnya']);
            $table->string('subject');
            $table->longText('message');
            $table->json('attachments')->nullable();
            $table->string('location')->nullable();
            $table->enum('status', ['received', 'read', 'in_progress', 'resolved', 'closed'])->default('received');
            $table->enum('priority', ['low', 'medium', 'high', 'urgent'])->default('medium');
            $table->longText('response')->nullable();
            $table->foreignId('responded_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('responded_at')->nullable();
            $table->timestamp('resolved_at')->nullable();
            $table->tinyInteger('satisfaction_rating')->nullable();
            $table->boolean('is_anonymous')->default(false);
            $table->boolean('is_public')->default(false);
            $table->timestamps();
        });

        // Guest books table (Buku Tamu Digital)
        Schema::create('guest_books', function (Blueprint $table) {
            $table->id();
            $table->string('visitor_name');
            $table->string('institution')->nullable();
            $table->enum('purpose', ['kunjungan_dinas', 'penelitian', 'kkn', 'studi_banding', 'tamu_umum', 'lainnya'])->default('tamu_umum');
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->text('message')->nullable();
            $table->string('photo_path')->nullable(); // selfie
            $table->datetime('visited_at');
            $table->foreignId('responded_by')->nullable()->constrained('users')->nullOnDelete();
            $table->text('response')->nullable();
            $table->timestamps();
        });

        // Newsletter subscribers
        Schema::create('newsletter_subscribers', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->string('name')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamp('confirmed_at')->nullable();
            $table->string('token')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('newsletter_subscribers');
        Schema::dropIfExists('guest_books');
        Schema::dropIfExists('complaints');
        Schema::dropIfExists('letter_logs');
        Schema::dropIfExists('letter_requests');
        Schema::dropIfExists('letter_types');
    }
};
