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
        Schema::create('metric_history_run', function (Blueprint $table) {
            $table->id();
            $table->string('url');
            $table->decimal('accesibility_metric', 3, 2)->nullable();
            $table->decimal('pwa_metric', 3, 2)->nullable();
            $table->decimal('performance_metric', 3, 2)->nullable();
            $table->decimal('seo_metric', 3, 2)->nullable();
            $table->decimal('best_practices_metric', 3, 2)->nullable();
            $table->unsignedBigInteger('strategy_id');
            $table->foreign('strategy_id', 'FK_MHR_S')->references('id')->on('strategy');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {   
        Schema::table('metric_history_run', function (Blueprint $table) {
            $table->dropForeign('FK_MHR_S');
        });    
        Schema::dropIfExists('metric_history_run');
    }
};