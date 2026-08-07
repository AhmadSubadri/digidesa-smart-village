<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Social Aid Programs table
        Schema::create('social_aid_programs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->unique()->nullable();
            $table->text('description')->nullable();
            $table->enum('source', ['pusat', 'provinsi', 'kabupaten', 'desa'])->default('pusat');
            $table->date('period_start')->nullable();
            $table->date('period_end')->nullable();
            $table->decimal('budget', 20, 2)->default(0);
            $table->string('managing_agency')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Social Aid Recipients table
        Schema::create('social_aid_recipients', function (Blueprint $table) {
            $table->id();
            $table->foreignId('program_id')->constrained('social_aid_programs')->cascadeOnDelete();
            $table->foreignId('resident_id')->nullable()->constrained('residents')->nullOnDelete();
            $table->foreignId('family_id')->nullable()->constrained('families')->nullOnDelete();
            $table->decimal('amount', 20, 2)->default(0);
            $table->tinyInteger('period_month')->nullable();
            $table->year('period_year')->nullable();
            $table->enum('status', ['proposed', 'verified', 'approved', 'distributed', 'returned'])->default('proposed');
            $table->date('distribution_date')->nullable();
            $table->text('notes')->nullable();
            $table->foreignId('verified_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });

        // Posyandu Units table
        Schema::create('posyandu_units', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('padukuhan_id')->nullable()->constrained()->nullOnDelete();
            $table->text('address')->nullable();
            $table->integer('kader_count')->default(0);
            $table->string('schedule_day')->nullable();
            $table->string('schedule_week')->nullable();
            $table->string('coordinator_name')->nullable();
            $table->string('coordinator_phone')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Stunting Records table
        Schema::create('stunting_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('resident_id')->constrained('residents')->cascadeOnDelete();
            $table->foreignId('posyandu_id')->nullable()->constrained('posyandu_units')->nullOnDelete();
            $table->date('measurement_date');
            $table->integer('age_months');
            $table->decimal('weight_kg', 5, 2)->nullable();
            $table->decimal('height_cm', 5, 2)->nullable();
            $table->decimal('head_circumference', 5, 2)->nullable();
            $table->enum('nutritional_status', ['normal', 'underweight', 'stunted', 'wasted', 'obese'])->nullable();
            $table->decimal('z_score_wfa', 5, 2)->nullable(); // weight-for-age
            $table->decimal('z_score_hfa', 5, 2)->nullable(); // height-for-age
            $table->decimal('z_score_wfh', 5, 2)->nullable(); // weight-for-height
            $table->json('immunization_status')->nullable();
            $table->text('notes')->nullable();
            $table->foreignId('recorded_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });

        // Pregnant Mothers table
        Schema::create('pregnant_mothers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('resident_id')->constrained('residents')->cascadeOnDelete();
            $table->foreignId('posyandu_id')->nullable()->constrained('posyandu_units')->nullOnDelete();
            $table->date('pregnancy_start_date')->nullable();
            $table->date('estimated_delivery_date')->nullable();
            $table->integer('checkup_count')->default(0);
            $table->boolean('high_risk')->default(false);
            $table->string('blood_type')->nullable();
            $table->json('complications')->nullable();
            $table->enum('status', ['pregnant', 'delivered', 'miscarriage'])->default('pregnant');
            $table->date('delivery_date')->nullable();
            $table->string('delivery_type')->nullable();
            $table->decimal('baby_weight', 5, 2)->nullable();
            $table->decimal('baby_height', 5, 2)->nullable();
            $table->text('notes')->nullable();
            $table->foreignId('recorded_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });

        // UMKM table
        Schema::create('umkm', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('owner_name')->nullable();
            $table->foreignId('owner_resident_id')->nullable()->constrained('residents')->nullOnDelete();
            $table->longText('description')->nullable();
            $table->enum('category', ['kuliner', 'kerajinan', 'fashion', 'pertanian', 'jasa', 'perdagangan', 'lainnya'])->default('lainnya');
            $table->text('address')->nullable();
            $table->foreignId('padukuhan_id')->nullable()->constrained()->nullOnDelete();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            $table->json('social_media')->nullable();
            $table->json('products')->nullable(); // [{name, description, price, photo}]
            $table->json('photos')->nullable();
            $table->decimal('coordinates_lat', 10, 8)->nullable();
            $table->decimal('coordinates_lng', 11, 8)->nullable();
            $table->boolean('is_verified')->default(false);
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });

        // Destinations table (Wisata)
        Schema::create('destinations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->longText('description')->nullable();
            $table->enum('category', ['alam', 'budaya', 'edukasi', 'kuliner', 'religi', 'lainnya'])->default('lainnya');
            $table->text('address')->nullable();
            $table->foreignId('padukuhan_id')->nullable()->constrained()->nullOnDelete();
            $table->json('photos')->nullable();
            $table->decimal('coordinates_lat', 10, 8)->nullable();
            $table->decimal('coordinates_lng', 11, 8)->nullable();
            $table->json('opening_hours')->nullable();
            $table->decimal('ticket_price', 10, 2)->nullable();
            $table->json('facilities')->nullable();
            $table->string('contact_phone')->nullable();
            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });

        // Village Assets table (Inventaris)
        Schema::create('village_assets', function (Blueprint $table) {
            $table->id();
            $table->string('asset_code')->unique();
            $table->string('name');
            $table->enum('category', ['tanah', 'bangunan', 'kendaraan', 'peralatan', 'aset_tetap_lainnya']);
            $table->text('description')->nullable();
            $table->date('acquisition_date')->nullable();
            $table->decimal('acquisition_value', 20, 2)->default(0);
            $table->enum('current_condition', ['baik', 'rusak_ringan', 'rusak_berat', 'hilang'])->default('baik');
            $table->string('location')->nullable();
            $table->integer('quantity')->default(1);
            $table->string('unit')->nullable();
            $table->string('photo_path')->nullable();
            $table->string('source_fund')->nullable();
            $table->string('responsible_person')->nullable();
            $table->text('notes')->nullable();
            $table->decimal('depreciation_value', 20, 2)->default(0);
            $table->date('disposal_date')->nullable();
            $table->timestamps();
        });

        // Attendances table (Kehadiran Perangkat)
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('official_id')->constrained('officials')->cascadeOnDelete();
            $table->date('date');
            $table->time('check_in')->nullable();
            $table->time('check_out')->nullable();
            $table->enum('status', ['hadir', 'izin', 'sakit', 'dinas_luar', 'alpha'])->default('hadir');
            $table->text('notes')->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->string('photo_path')->nullable(); // selfie
            $table->timestamps();

            $table->unique(['official_id', 'date']);
        });

        // Land Records table (Data Tanah)
        Schema::create('land_records', function (Blueprint $table) {
            $table->id();
            $table->text('certificate_number')->nullable(); // encrypted
            $table->foreignId('owner_resident_id')->nullable()->constrained('residents')->nullOnDelete();
            $table->text('owner_name')->nullable(); // encrypted
            $table->enum('land_type', ['sawah', 'tegal', 'pekarangan', 'lainnya'])->default('pekarangan');
            $table->decimal('area_m2', 10, 2)->nullable();
            $table->text('address')->nullable();
            $table->foreignId('padukuhan_id')->nullable()->constrained()->nullOnDelete();
            $table->enum('ownership_type', ['hak_milik', 'hak_guna', 'hak_pakai', 'tanah_negara', 'tanah_desa'])->default('hak_milik');
            $table->json('coordinates')->nullable(); // GeoJSON polygon
            $table->text('tax_number')->nullable(); // encrypted
            $table->text('notes')->nullable();
            $table->enum('status', ['active', 'disputed', 'sold'])->default('active');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('land_records');
        Schema::dropIfExists('attendances');
        Schema::dropIfExists('village_assets');
        Schema::dropIfExists('destinations');
        Schema::dropIfExists('umkm');
        Schema::dropIfExists('pregnant_mothers');
        Schema::dropIfExists('stunting_records');
        Schema::dropIfExists('posyandu_units');
        Schema::dropIfExists('social_aid_recipients');
        Schema::dropIfExists('social_aid_programs');
    }
};
