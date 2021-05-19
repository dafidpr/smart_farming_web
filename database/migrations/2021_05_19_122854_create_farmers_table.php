<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFarmersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('farmers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('farmer_group_id');
            $table->string('username');
            $table->string('password');
            $table->string('name');
            $table->enum('gender', ['male', 'female']);
            $table->string('phone', 12);
            $table->string('email');
            $table->string('birthplace');
            $table->date('birthday');
            $table->float('land_area');
            $table->string('tool_access_code');
            $table->enum('block', ['Y', 'N']);
            $table->enum('status', ['pending', 'approve', 'rejected']);
            $table->timestamps();
            $table->foreign('farmer_group_id')->references('id')->on('farmer_groups')->onDelete('restrict')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('farmers');
    }
}
