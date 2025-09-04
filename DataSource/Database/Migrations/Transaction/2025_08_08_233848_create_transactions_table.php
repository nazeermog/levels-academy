<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('parent_id')->index();
            $table->unsignedBigInteger('course_id')->index();
            $table->unsignedBigInteger('student_id')->index();
            $table->decimal('price', 10, 2);
            $table->text('desc')->nullable();
            $table->enum('type', ['monthly', 'once'])->nullable();
            $table->boolean('is_credit')->default(0); // 1 = adding money, 0 = spending money
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
};
