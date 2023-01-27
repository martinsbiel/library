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
        Schema::table('book_loans', function (Blueprint $table) {
            $table->boolean('returned')->default(false)->after('book_id');
            $table->boolean('delayed')->default(false)->after('returned');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('book_loans', function (Blueprint $table) {
            $table->dropColumn('returned');
            $table->dropColumn('delayed');
        });
    }
};
