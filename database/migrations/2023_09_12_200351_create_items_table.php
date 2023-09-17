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
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->string('name', 100)->index();
            $table->string('model_number', 100)->index();
            $table->unsignedBigInteger('type')->index();
            $table->Integer('stock')->nullable(false);
            $table->smallInteger('spicy')->nullable()->index();
            $table->string('detail', 500)->nullable();
            $table->string('img_path')->nullable();
            $table->timestamps();

            // typeカラムの外部キー制約追加
            $table->foreign('type')->references('id')->on('item_types');
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
