<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Tambah atribut Letter C & Tanah Kas Desa ke land_records
        Schema::table('land_records', function (Blueprint $table) {
            $table->string('kohir_number', 50)->nullable()->after('certificate_number')->index()->comment('Nomor Buku C / Kohir');
            $table->string('persil_number', 50)->nullable()->after('kohir_number')->index()->comment('Nomor Persil');
            $table->string('land_class', 20)->nullable()->after('persil_number')->comment('Kelas Tanah e.g. S.I, S.II, D.I, D.II');
            $table->enum('usage_type', [
                'milik_warga', 'tanah_kas_desa', 'bengkok', 'pelungguh', 'fasilitas_umum', 'makam', 'lainnya'
            ])->default('milik_warga')->after('ownership_type');
        });

        // 2. Buat tabel Buku Mutasi Tanah Desa (land_mutations)
        Schema::create('land_mutations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('land_record_id')->constrained('land_records')->cascadeOnDelete();
            $table->date('mutation_date');
            $table->enum('mutation_type', [
                'jual_beli', 'waris', 'hibah', 'tukar_menukar', 'wakaf', 'pemecahan', 'penggabungan', 'lainnya'
            ])->default('jual_beli');
            $table->string('old_owner_name');
            $table->string('new_owner_name');
            $table->text('new_owner_nik')->nullable();
            $table->decimal('area_transferred_m2', 10, 2);
            $table->decimal('remaining_area_m2', 10, 2)->nullable();
            $table->string('deed_number')->nullable()->comment('Nomor Akta / Surat Bukti');
            $table->string('notary_name')->nullable()->comment('Nama PPAT / Camat');
            $table->text('notes')->nullable();
            $table->string('document_scan_path')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('land_mutations');

        Schema::table('land_records', function (Blueprint $table) {
            $table->dropColumn([
                'kohir_number',
                'persil_number',
                'land_class',
                'usage_type',
            ]);
        });
    }
};
