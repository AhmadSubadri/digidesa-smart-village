<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Budget periods table (APBKal per tahun)
        Schema::create('budget_periods', function (Blueprint $table) {
            $table->id();
            $table->year('fiscal_year')->unique();
            $table->string('title')->nullable();
            $table->enum('status', ['draft', 'active', 'closed'])->default('draft');
            $table->decimal('total_income', 20, 2)->default(0);
            $table->decimal('total_expense', 20, 2)->default(0);
            $table->decimal('total_financing', 20, 2)->default(0);
            $table->string('document_path')->nullable(); // PDF APBKal
            $table->timestamps();
        });

        // Budget items table (Rincian APBKal)
        Schema::create('budget_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('budget_period_id')->constrained()->cascadeOnDelete();
            $table->enum('type', ['income', 'expense', 'financing']);
            $table->string('code')->nullable(); // kode rekening
            $table->string('category');
            $table->string('sub_category')->nullable();
            $table->string('item_name');
            $table->decimal('planned_amount', 20, 2)->default(0);
            $table->decimal('revised_amount', 20, 2)->default(0);
            $table->decimal('realized_amount', 20, 2)->default(0);
            $table->decimal('percentage', 5, 2)->default(0); // realisasi %
            $table->string('source_fund')->nullable();
            $table->text('notes')->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        // Developments table (Proyek Pembangunan)
        Schema::create('developments', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->longText('description')->nullable();
            $table->string('location_text')->nullable();
            $table->foreignId('budget_period_id')->nullable()->constrained()->nullOnDelete();
            $table->decimal('budget_amount', 20, 2)->default(0);
            $table->string('contractor')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->tinyInteger('progress_percentage')->default(0);
            $table->enum('status', ['planned', 'procurement', 'ongoing', 'completed', 'delayed'])->default('planned');
            $table->json('before_photos')->nullable();
            $table->json('progress_photos')->nullable();
            $table->json('after_photos')->nullable();
            $table->decimal('coordinates_lat', 10, 8)->nullable();
            $table->decimal('coordinates_lng', 11, 8)->nullable();
            $table->string('volume')->nullable();
            $table->string('unit')->nullable();
            $table->integer('beneficiaries_count')->default(0);
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        // IDM Scores table
        Schema::create('idm_scores', function (Blueprint $table) {
            $table->id();
            $table->year('year')->unique();
            $table->decimal('total_score', 5, 4)->default(0);
            $table->enum('status', ['sangat_tertinggal', 'tertinggal', 'berkembang', 'maju', 'mandiri'])->default('berkembang');
            $table->decimal('ike_score', 5, 4)->default(0); // Indeks Ketahanan Ekonomi
            $table->decimal('ikl_score', 5, 4)->default(0); // Indeks Ketahanan Lingkungan
            $table->decimal('iks_score', 5, 4)->default(0); // Indeks Ketahanan Sosial
            $table->integer('national_rank')->nullable();
            $table->integer('provincial_rank')->nullable();
            $table->integer('district_rank')->nullable();
            $table->string('data_source_url')->nullable();
            $table->text('notes')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });

        // IDM Indicators table
        Schema::create('idm_indicators', function (Blueprint $table) {
            $table->id();
            $table->foreignId('idm_score_id')->constrained()->cascadeOnDelete();
            $table->enum('dimension', ['ekonomi', 'lingkungan', 'sosial']);
            $table->string('indicator_name');
            $table->decimal('score', 5, 4)->default(0);
            $table->decimal('weight', 5, 4)->default(0);
            $table->text('description')->nullable();
            $table->text('recommendation')->nullable();
            $table->timestamps();
        });

        // SDGs Goals table (18 tujuan - static seed)
        Schema::create('sdgs_goals', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('number')->unique(); // 1-18
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('icon')->nullable();
            $table->string('color')->nullable(); // official SDG color
            $table->timestamps();
        });

        // SDGs Scores table (per goal per year)
        Schema::create('sdgs_scores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sdgs_goal_id')->constrained()->cascadeOnDelete();
            $table->year('year');
            $table->decimal('score', 5, 2)->default(0); // percentage
            $table->enum('status', ['belum_tercapai', 'berkembang', 'tercapai'])->default('berkembang');
            $table->json('indicators_data')->nullable(); // [{name, value, target, unit}]
            $table->text('notes')->nullable();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->unique(['sdgs_goal_id', 'year']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sdgs_scores');
        Schema::dropIfExists('sdgs_goals');
        Schema::dropIfExists('idm_indicators');
        Schema::dropIfExists('idm_scores');
        Schema::dropIfExists('developments');
        Schema::dropIfExists('budget_items');
        Schema::dropIfExists('budget_periods');
    }
};
