<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDonationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('donations', function (Blueprint $table) {
            $table->id();
            $table->integer('donor_id');
            $table->integer('charity_id');
            $table->integer('campaign_id')->nullable();
            $table->integer('donation_type_id');
            $table->string('donation_way');
            $table->integer('payment_link_id')->nullable();
            $table->integer('donation_amount')->nullable();
            $table->integer('donor_phone')->nullable();
            $table->string('donor_district')->nullable();
            $table->string('donor_city')->nullable();
            $table->string('donor_address')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('donations');
    }
}
