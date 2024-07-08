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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("category_id");
            $table->foreign("category_id")->references('id')->on('categories')->onDelete('cascade');
            $table->unsignedBigInteger("trainer_id");
            $table->foreign("trainer_id")->references('id')->on('trainers')->onDelete('cascade');
            $table->string("name");
            $table->text("description");
            $table->unsignedBigInteger('age');
            $table->unsignedBigInteger("number_of_students");
            $table->unsignedBigInteger("number_of_students_paid")->default(0);
            $table->unsignedBigInteger("price");
            $table->unsignedBigInteger("number_of_sessions");
            $table->date('start_date');
            $table->date('end_date');
            $table->Time('time');
            $table->text("photo");
            $table->enum('status',['available','unavailable','completed']);
            $table->timestamps();
        });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
