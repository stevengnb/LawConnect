<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('lawyers', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name');
            $table->string('email');
            $table->string('phoneNumber');
            $table->string('gender');
            $table->string('password');
            $table->string('education');
            $table->string('address');
            $table->date('experience');
            $table->date('dob');
            $table->integer('rate');
            // $table->string('profile');
        });
        DB::statement("ALTER TABLE lawyers ADD profileLink MEDIUMBLOB");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lawyers');
    }
};
