<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pack_id');
            $table->unsignedBigInteger('lang_id');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('pack_id')
                    ->references('id')
                    ->on('packages')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');

            $table->foreign('lang_id')
                    ->references('id')
                    ->on('languages')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('usages');
    }
}
