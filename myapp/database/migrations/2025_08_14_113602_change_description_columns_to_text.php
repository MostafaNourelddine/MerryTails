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
        // Change items table description column from string to text
        Schema::table('items', function (Blueprint $table) {
            $table->text('description')->change();
        });

        // Change categories table description column from string to text
        Schema::table('categories', function (Blueprint $table) {
            $table->text('description')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Revert items table description column back to string
        Schema::table('items', function (Blueprint $table) {
            $table->string('description')->change();
        });

        // Revert categories table description column back to string
        Schema::table('categories', function (Blueprint $table) {
            $table->string('description')->change();
        });
    }
};
