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
        Schema::create('hotels', function (Blueprint $table) {
            $table->id();
            $table->text("h_name");
            $table->integer("h_category");
            $table->longText("h_body");
            $table->string("h_image");
            $table->integer("h_stars");
            $table->mediumText("h_address");
            $table->integer("h_capacity");
            $table->time("h_in");
            $table->time("h_out");
            $table->text("h_roles");
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
        Schema::dropIfExists('hotels');
    }
};
