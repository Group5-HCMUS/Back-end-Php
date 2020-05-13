<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ParentChildren5ebac46a5a31b extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parent_children', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('parent_id');
            $table->unsignedBigInteger('child_id');
            $table->timestamps();

            $table->index('parent_id');
            $table->foreign('parent_id')->references('id')->on('parents');

            $table->index('child_id');
            $table->foreign('child_id')->references('id')->on('children');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('parent_children');
    }
}
