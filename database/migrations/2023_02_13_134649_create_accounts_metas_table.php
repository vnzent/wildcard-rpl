<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts_metas', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('model_id')->nullable();
            $table->string('model_type')->nullable();

            $table->foreignId('account_id')->references('id')->on('accounts')->onDelete('cascade');
            $table->string('key')->index();
            $table->json('value')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (config('filament-accounts.features.meta')) {
            Schema::dropIfExists('accounts_metas');
        }
    }
};
