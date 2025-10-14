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
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->string('cep', 20)->nullable();
            $table->string('state', 100)->nullable();
            $table->string('city', 150)->nullable();
            $table->string('neighborhood', 150)->nullable();
            $table->string('address', 255)->nullable();
            $table->string('number', 50)->nullable();
            $table->string('contact_name', 150);
            $table->string('contact_email')->nullable();
            $table->string('contact_phone', 50)->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('contacts');
    }
};
