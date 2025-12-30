<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table) {
            // Kita tambah 3 kolom baru
            $table->string('buyer_name')->after('user_id')->nullable();
            $table->string('buyer_email')->after('buyer_name')->nullable();
            $table->string('buyer_phone')->after('buyer_email')->nullable();
            $table->string('buyer_nik')->after('buyer_phone')->nullable(); // Penting buat cek KTP
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            //
        });
    }
};
