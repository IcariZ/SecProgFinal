<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('answers', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->dropForeign(['test_id']);
            $table->foreign('test_id')->references('id')->on('tests')->onDelete('cascade');

            $table->dropForeign(['question_id']);
            $table->foreign('question_id')->references('id')->on('questions')->onDelete('cascade');

            $table->dropForeign(['option_id']);
            $table->foreign('option_id')->references('id')->on('options')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('answers', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->foreign('user_id')->references('id')->on('users');

            $table->dropForeign(['test_id']);
            $table->foreign('test_id')->references('id')->on('tests');

            $table->dropForeign(['question_id']);
            $table->foreign('question_id')->references('id')->on('questions');

            $table->dropForeign(['option_id']);
            $table->foreign('option_id')->references('id')->on('options');
        });
    }
};
