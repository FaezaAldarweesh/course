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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string('phone')->unique();
            $table->string('email')->unique();
            $table->text("personal_photo");
            $table->date('birth_date');
            $table->string("educational_level");
            $table->enum('gender',['female','male']);
            $table->string("location");
            $table->string('password');
            $table->timestamps();
        });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
