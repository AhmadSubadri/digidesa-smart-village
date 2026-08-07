<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Padukuhans table (18 padukuhan Condongcatur)
        Schema::create('padukuhans', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->unique()->nullable();
            $table->string('head_name')->nullable();
            $table->string('head_phone')->nullable();
            $table->decimal('area_size', 10, 2)->nullable(); // in Ha
            $table->integer('population')->default(0);
            $table->integer('families_count')->default(0);
            $table->json('coordinates')->nullable(); // GeoJSON polygon
            $table->integer('total_rt')->default(0);
            $table->integer('total_rw')->default(0);
            $table->text('description')->nullable();
            $table->string('photo')->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        // RWs table
        Schema::create('rws', function (Blueprint $table) {
            $table->id();
            $table->string('number');
            $table->foreignId('padukuhan_id')->constrained()->cascadeOnDelete();
            $table->string('head_name')->nullable();
            $table->string('head_phone')->nullable();
            $table->timestamps();
        });

        // RTs table
        Schema::create('rts', function (Blueprint $table) {
            $table->id();
            $table->string('number');
            $table->foreignId('padukuhan_id')->constrained()->cascadeOnDelete();
            $table->foreignId('rw_id')->nullable()->constrained()->nullOnDelete();
            $table->string('head_name')->nullable();
            $table->string('head_phone')->nullable();
            $table->integer('households_count')->default(0);
            $table->timestamps();
        });

        // Families table (Kartu Keluarga)
        Schema::create('families', function (Blueprint $table) {
            $table->id();
            $table->text('kk_number'); // encrypted
            $table->foreignId('padukuhan_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('rt_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('rw_id')->nullable()->constrained()->nullOnDelete();
            $table->text('address')->nullable();
            $table->enum('economic_status', ['sejahtera', 'pra_sejahtera', 'miskin'])->nullable();
            $table->enum('house_ownership', ['milik_sendiri', 'sewa', 'kontrak', 'numpang'])->nullable();
            $table->enum('house_condition', ['permanen', 'semi_permanen', 'tidak_permanen'])->nullable();
            $table->enum('status', ['active', 'dissolved'])->default('active');
            $table->timestamps();
        });

        // Residents table (Data Penduduk)
        Schema::create('residents', function (Blueprint $table) {
            $table->id();
            $table->text('nik'); // encrypted
            $table->text('kk_number'); // encrypted
            $table->text('full_name'); // encrypted
            $table->string('birth_place')->nullable();
            $table->date('birth_date')->nullable();
            $table->enum('gender', ['L', 'P'])->nullable();
            $table->enum('blood_type', ['A', 'B', 'AB', 'O', 'A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-', 'tidak_tahu'])->nullable();
            $table->enum('religion', ['islam', 'kristen', 'katolik', 'hindu', 'buddha', 'konghucu', 'lainnya'])->nullable();
            $table->enum('marital_status', ['belum_kawin', 'kawin', 'cerai_hidup', 'cerai_mati'])->nullable();
            $table->enum('education_level', ['tidak_sekolah', 'sd', 'sltp', 'slta', 'd1', 'd2', 'd3', 's1', 's2', 's3'])->nullable();
            $table->string('occupation')->nullable();
            $table->enum('citizenship', ['WNI', 'WNA'])->default('WNI');
            $table->text('address')->nullable();
            $table->foreignId('padukuhan_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('rt_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('rw_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('family_id')->nullable()->constrained('families')->nullOnDelete();
            $table->string('photo_path')->nullable();
            $table->text('father_nik')->nullable(); // encrypted
            $table->text('mother_nik')->nullable(); // encrypted
            $table->boolean('is_head_of_family')->default(false);
            $table->string('disability_type')->nullable();
            $table->enum('status', ['active', 'moved_out', 'moved_in', 'deceased', 'temporary'])->default('active');
            $table->date('moved_date')->nullable();
            $table->date('death_date')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        // Warga users table (portal warga - separate from admin users)
        Schema::create('warga_users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('resident_id')->nullable()->constrained('residents')->nullOnDelete();
            $table->text('nik'); // encrypted
            $table->string('name');
            $table->string('email')->unique()->nullable();
            $table->string('phone')->nullable();
            $table->string('password');
            $table->boolean('is_verified')->default(false);
            $table->timestamp('verified_at')->nullable();
            $table->boolean('is_active')->default(true);
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('warga_users');
        Schema::dropIfExists('residents');
        Schema::dropIfExists('families');
        Schema::dropIfExists('rts');
        Schema::dropIfExists('rws');
        Schema::dropIfExists('padukuhans');
    }
};
