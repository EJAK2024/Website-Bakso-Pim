<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->index('status');
            $table->index('is_read');
            $table->index('created_at');
            $table->index('payment_method');
        });

        Schema::table('order_items', function (Blueprint $table) {
            $table->index(['order_id', 'menu_id']);
        });

        Schema::table('menus', function (Blueprint $table) {
            $table->index('category');
            $table->index('is_available');
        });

        Schema::table('messages', function (Blueprint $table) {
            $table->index('is_read');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropIndex(['status']);
            $table->dropIndex(['is_read']);
            $table->dropIndex(['created_at']);
            $table->dropIndex(['payment_method']);
        });

        Schema::table('order_items', function (Blueprint $table) {
            $table->dropIndex(['order_id', 'menu_id']);
        });

        Schema::table('menus', function (Blueprint $table) {
            $table->dropIndex(['category']);
            $table->dropIndex(['is_available']);
        });

        Schema::table('messages', function (Blueprint $table) {
            $table->dropIndex(['is_read']);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['status']);
        });
    }
};
