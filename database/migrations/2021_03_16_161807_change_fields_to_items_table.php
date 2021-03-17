<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeFieldsToItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('items', function (Blueprint $table) {
            $table->dropColumn(['code_item', 'description_code', 'unit_item', 'description_unit']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('items', function (Blueprint $table) {
            $table->string('code_item')->nullable()->after('enabled');
            $table->string('description_code')->nullable()->after('enabled');
            $table->string('unit_item')->nullable()->after('enabled');
            $table->string('description_unit')->nullable()->after('enabled');
        });
    }
}
