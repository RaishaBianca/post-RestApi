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
        Schema::connection('mysql_post')->create('posting', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('user_id'); 
            $table->unsignedBigInteger('post_id'); 
            $table->foreign('user_id')->references('id')->on('service_user.users');
            $table->foreign('post_id')->references('id')->on('posts');
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('mysql_post')->dropIfExists('posting');
    }
};
