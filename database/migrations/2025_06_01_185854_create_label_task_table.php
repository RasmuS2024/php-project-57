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
        Schema::create('label_task', function (Blueprint $table) {
            $table->id();
            $table->foreignId('task_id')->constrained()->cascadeOnDelete();
            $table->unsignedBigInteger('label_id');
            $table->foreign('label_id')
                ->references('id')->on('labels')
                ->onDelete('restrict');
            $table->unique(['task_id', 'label_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('label_task');
    }
};
