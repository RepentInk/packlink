<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('media', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pack_id');
            $table->unsignedBigInteger('install_id');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('pack_id')
                    ->references('id')
                    ->on('packages')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');

            $table->foreign('install_id')
                    ->references('id')
                    ->on('installations')
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
        Schema::dropIfExists('media');
    }
}
