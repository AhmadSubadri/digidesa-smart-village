<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Officials table (Perangkat Desa)
        Schema::create('officials', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('nip')->nullable();
            $table->string('position'); // jabatan
            $table->string('rank')->nullable(); // golongan
            $table->string('photo')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->date('period_start')->nullable();
            $table->date('period_end')->nullable();
            $table->text('bio')->nullable();
            $table->string('education')->nullable();
            $table->foreignId('padukuhan_id')->nullable()->constrained()->nullOnDelete();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Institutions table (Lembaga Desa)
        Schema::create('institutions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('abbreviation')->nullable();
            $table->enum('type', ['legislatif', 'pemberdayaan', 'perempuan', 'pemuda', 'kewilayahan', 'keamanan', 'ekonomi', 'pertanian', 'kesehatan', 'lainnya']);
            $table->text('description')->nullable();
            $table->string('logo')->nullable();
            $table->string('chairman_name')->nullable();
            $table->string('chairman_photo')->nullable();
            $table->string('secretary_name')->nullable();
            $table->integer('members_count')->default(0);
            $table->string('period')->nullable();
            $table->string('legal_basis')->nullable();
            $table->json('program_kerja')->nullable();
            $table->string('address')->nullable();
            $table->string('phone')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        // Official-Institution pivot
        Schema::create('institution_official', function (Blueprint $table) {
            $table->id();
            $table->foreignId('institution_id')->constrained()->cascadeOnDelete();
            $table->foreignId('official_id')->constrained()->cascadeOnDelete();
            $table->string('role')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('institution_official');
        Schema::dropIfExists('institutions');
        Schema::dropIfExists('officials');
    }
};
