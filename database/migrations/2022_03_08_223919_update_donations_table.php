<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateDonationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('donations', function($table) {
            $table->renameColumn('payment_link_id', 'payment_link');
            $table->boolean('acceptance')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('donations', function($table) {
            $table->dropColumn('payment_link');
            $table->dropColumn('acceptance');
        });
    }
}
