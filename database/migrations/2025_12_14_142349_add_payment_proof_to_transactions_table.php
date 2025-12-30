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
        // Cek dulu: Apakah kolom 'payment_proof' SUDAH ADA di tabel 'transactions'?
        if (!Schema::hasColumn('transactions', 'payment_proof')) {
            // Kalau BELUM ada, baru kita buat
            Schema::table('transactions', function (Blueprint $table) {
                $table->string('payment_proof')->nullable()->after('total_price');
            });
        }
    }

    public function down()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn('payment_proof');
        });
    }
};
