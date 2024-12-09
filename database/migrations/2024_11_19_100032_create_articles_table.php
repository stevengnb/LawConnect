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
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('title');
            $table->string('description');
            $table->date('createDate');
            $table->string('imagePath');
            $table->unsignedBigInteger('lawyer_id');
            $table->foreign('lawyer_id')->on('lawyers')->references('id')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('expertise_id');
            $table->foreign('expertise_id')->on('lawyers')->references('id')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
