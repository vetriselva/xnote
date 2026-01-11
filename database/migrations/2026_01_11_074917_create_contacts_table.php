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
            $table->string('phone')->nullable()->unique('phone');
            $table->string('email')->nullable();
            $table->string('company')->nullable();
            $table->text('address')->nullable();
            $table->boolean('has_reminder')->default(false)->nullable();
            $table->dateTime('reminder_at')->nullable()->after('notes');
            $table->string('reminder_note')->nullable()->after('reminder_at');
            $table->timestamps();
            $table->softDeletes();
            $table->index('tenant_id');
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
