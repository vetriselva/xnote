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
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tenant_id');

            $table->string('name');
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->longText('others')->nullable();
            $table->text('address')->nullable();

            $table->boolean('has_reminder')->default(false);
            $table->dateTime('reminder_at')->nullable();
            $table->string('reminder_note')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};
