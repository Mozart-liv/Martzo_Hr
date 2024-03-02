<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->integer('phone')->nullable();
            $table->enum('gender', ['male', 'female'])->nullable();
            $table->integer('role_id')->nullable();
            $table->longText('address')->nullable();
            $table->string('nrc')->nullable();
            $table->string('img')->nullable();
            $table->bigInteger('employee_id')->nullable();
            $table->bigInteger('department_id')->nullable();
            $table->date('date_of_join')->default(Carbon::now()->format('Y-m-d'));
            $table->boolean('is_present')->default(1);
            $table->rememberToken();
            $table->foreignId('current_team_id')->nullable();
            $table->string('profile_photo_path', 2048)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
