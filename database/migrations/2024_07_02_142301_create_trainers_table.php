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
        Schema::create('trainers', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("educational_level");
            $table->enum('gender',['female','male']);
            $table->string("instagram");
            $table->string('email')->unique();
            $table->string('phone')->unique();
            $table->text("certificate");
            $table->text("personal_photo");
            $table->text("identity_photo");
            $table->date('birth_date');
            $table->text("about");
            $table->timestamps();
        });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trainers');
    }
};
