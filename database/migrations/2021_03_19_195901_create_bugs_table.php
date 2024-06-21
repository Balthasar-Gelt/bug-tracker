<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBugsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bugs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('short_description', 100);
            $table->text('description');
            $table->boolean('is_resolved')->default(0);
            $table->foreignId('project_id')->constrained()->onDelete('cascade');
            $table->bigInteger('created_by')->unsigned();
            $table->bigInteger('asignee')->nullable()->unsigned();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('assignee')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bugs', function (Blueprint $table) {
            $table->dropForeign(['created_by']);
            $table->dropColumn('created_by');
            $table->dropForeign(['asignee']);
            $table->dropColumn('asignee');
        });

        Schema::dropIfExists('bugs');
    }
}
