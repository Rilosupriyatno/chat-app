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
        Schema::create('chats', function (Blueprint $table) {
            $table->id();
            $table->integer('sender_id');
            $table->integer('recipient_id');
            $table->string('sender_name');
            $table->string('recipient_name');
            $table->text('message');
            $table->boolean('is_send')->default(false);
            $table->boolean('is_seen')->default(false);
            $table->boolean('is_read')->default(false);
            $table->boolean('is_deleted')->default(false);
            $table->string('attachments')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chats');
    }
};
