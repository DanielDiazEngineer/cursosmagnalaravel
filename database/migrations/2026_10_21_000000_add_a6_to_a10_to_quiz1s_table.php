<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddA6ToA10ToQuiz1sTable extends Migration
{
    /**
     * Quiz 1 grew from 5 to 10 questions.
     * Guarded with hasColumn because production was altered by hand in phpMyAdmin.
     */
    public function up()
    {
        $previous = 'a5';

        Schema::table('quiz1s', function (Blueprint $table) use (&$previous) {
            foreach (['a6', 'a7', 'a8', 'a9', 'a10'] as $column) {
                if (!Schema::hasColumn('quiz1s', $column)) {
                    $table->integer($column)->nullable()->after($previous);
                }
                $previous = $column;
            }
        });
    }

    public function down()
    {
        Schema::table('quiz1s', function (Blueprint $table) {
            foreach (['a6', 'a7', 'a8', 'a9', 'a10'] as $column) {
                if (Schema::hasColumn('quiz1s', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
}
