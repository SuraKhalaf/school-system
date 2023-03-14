<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('course_user', function (Blueprint $table) {
            $table->uuid('user_id');
            $table->uuid('course_id');
            $table->double('first')->nullable(true);
            $table->double('mid')->nullable(true);
            $table->double('final')->nullable(true);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
            $table->foreign('course_id')->references('id')->on('courses')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('course_user');
    }
};
