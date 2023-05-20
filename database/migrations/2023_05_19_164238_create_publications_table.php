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
        Schema::create('publications', function (Blueprint $table) {
            $table->id();
            $table->string('content', 255);
            $table->string('labels')->nullable();
            $table->foreignId('region_id')->nullable()->constrained()
                    ->onUpdate('cascade')
                    ->onDelete('restrict');
            $table->foreignId('publication_category_id')->nullable()->constrained()
                    ->onUpdate('cascade')
                    ->onDelete('restrict');
            $table->foreignId('user_id')->constrained()
                    ->onUpdate('cascade')
                    ->onDelete('restrict');

            $table->bigInteger('update_user_id',false,true)->nullable();
            $table->foreign('update_user_id')->references('id')->on('users')
                ->cascadeOnUpdate()
                ->restrictOnDelete();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('publications');
    }
};
