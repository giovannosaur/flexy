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
        Schema::create('flexy_requests', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('user_id');
            $table->date('requested_date');
            $table->enum('schedule_option', ['09:00-18:00', '10:00-19:00']);
            $table->enum('status', ['pending', 'accepted', 'declined'])->default('pending');
            $table->string('approved_by')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();
        
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('approved_by')->references('id')->on('users')->onDelete('set null');
        });        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('flexyrequests');
    }
};
