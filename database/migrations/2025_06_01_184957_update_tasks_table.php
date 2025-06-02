<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropColumn(['status', 'author', 'executor']);
        });

        Schema::table('tasks', function (Blueprint $table) {
            $table->foreignId('status_id')->constrained('task_statuses');
            $table->foreignId('author_id')->constrained('users');
            $table->foreignId('executor_id')->nullable()->constrained('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            // Удаляем связи и колонки
            $table->dropForeign(['status_id']);
            $table->dropForeign(['author_id']);
            $table->dropForeign(['executor_id']);
            
            $table->dropColumn(['status_id', 'author_id', 'executor_id']);
        });

        Schema::table('tasks', function (Blueprint $table) {
            // Восстанавливаем оригинальные колонки
            $table->string('status');
            $table->string('author');
            $table->string('executor');
        });
    }
};
