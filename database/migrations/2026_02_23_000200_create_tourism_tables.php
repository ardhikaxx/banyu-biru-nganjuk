<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2);
            $table->integer('quota_per_day')->default(100);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('ticket_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('order_code', 20)->unique();
            $table->date('visit_date');
            $table->integer('total_qty');
            $table->decimal('total_price', 10, 2);
            $table->string('payment_proof')->nullable();
            $table->enum('status', ['pending', 'confirmed', 'rejected'])->default('pending');
            $table->timestamp('confirmed_at')->nullable();
            $table->foreignId('confirmed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->text('rejection_note')->nullable();
            $table->timestamps();
        });

        Schema::create('ticket_order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ticket_order_id')->constrained('ticket_orders')->cascadeOnDelete();
            $table->foreignId('ticket_id')->constrained('tickets')->cascadeOnDelete();
            $table->string('ticket_code', 20)->unique();
            $table->string('qr_code_path');
            $table->integer('qty')->default(1);
            $table->decimal('price', 10, 2);
            $table->boolean('is_used')->default(false);
            $table->timestamp('used_at')->nullable();
            $table->timestamps();
        });

        Schema::create('places', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->text('description')->nullable();
            $table->integer('capacity');
            $table->decimal('price_per_day', 10, 2);
            $table->string('image')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('place_id')->constrained('places')->cascadeOnDelete();
            $table->string('booking_code', 20)->unique();
            $table->date('booking_date');
            $table->string('visitor_name', 100);
            $table->string('visitor_phone', 20);
            $table->text('visitor_address');
            $table->integer('num_persons');
            $table->decimal('total_price', 10, 2);
            $table->string('payment_proof')->nullable();
            $table->enum('status', ['pending', 'confirmed', 'rejected'])->default('pending');
            $table->timestamp('confirmed_at')->nullable();
            $table->foreignId('confirmed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->text('rejection_note')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->unique(['place_id', 'booking_date']);
        });

        Schema::create('bank_accounts', function (Blueprint $table) {
            $table->id();
            $table->string('bank_name', 100);
            $table->string('account_number', 50);
            $table->string('account_name', 100);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key', 100)->unique();
            $table->text('value')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
        Schema::dropIfExists('bank_accounts');
        Schema::dropIfExists('bookings');
        Schema::dropIfExists('places');
        Schema::dropIfExists('ticket_order_items');
        Schema::dropIfExists('ticket_orders');
        Schema::dropIfExists('tickets');
    }
};