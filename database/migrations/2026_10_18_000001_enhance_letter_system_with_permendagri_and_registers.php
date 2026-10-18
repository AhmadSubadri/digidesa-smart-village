<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Tambah kolom pendukung standar Permendagri & template docx ke letter_types
        Schema::table('letter_types', function (Blueprint $table) {
            $table->string('classification_code', 20)->nullable()->after('code')->comment('Kode Klasifikasi Arsip Kemendagri e.g. 470');
            $table->enum('template_type', ['blade', 'docx'])->default('blade')->after('template_path');
            $table->string('docx_template_path')->nullable()->after('template_type');
            $table->boolean('requires_rt_approval')->default(false)->after('needs_approval');
        });

        // 2. Tambah kolom nomor urut register, TTD RT/RW, dan notifikasi WA ke letter_requests
        Schema::table('letter_requests', function (Blueprint $table) {
            $table->unsignedInteger('sequence_number')->nullable()->after('letter_number')->comment('Nomor urut buku register per tahun');
            $table->string('docx_path')->nullable()->after('pdf_path');
            $table->foreignId('rt_rw_id')->nullable()->after('attachments')->constrained('users')->nullOnDelete();
            $table->timestamp('rt_rw_approved_at')->nullable()->after('rt_rw_id');
            $table->boolean('wa_notification_sent')->default(false)->after('signature_image_path');
        });

        // 3. Buat tabel Buku Agenda Surat Masuk & Keluar (Permendagri No. 47/2016)
        Schema::create('letter_registers', function (Blueprint $table) {
            $table->id();
            $table->enum('register_type', ['incoming', 'outgoing'])->default('outgoing')->index();
            $table->string('letter_number')->index();
            $table->date('letter_date');
            $table->string('sender_or_recipient');
            $table->string('subject');
            $table->text('summary')->nullable();
            $table->string('classification_code', 20)->nullable()->index();
            $table->foreignId('letter_request_id')->nullable()->constrained('letter_requests')->nullOnDelete();
            $table->string('document_file_path')->nullable();
            $table->foreignId('archived_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('letter_registers');

        Schema::table('letter_requests', function (Blueprint $table) {
            $table->dropForeign(['rt_rw_id']);
            $table->dropColumn([
                'sequence_number',
                'docx_path',
                'rt_rw_id',
                'rt_rw_approved_at',
                'wa_notification_sent',
            ]);
        });

        Schema::table('letter_types', function (Blueprint $table) {
            $table->dropColumn([
                'classification_code',
                'template_type',
                'docx_template_path',
                'requires_rt_approval',
            ]);
        });
    }
};
