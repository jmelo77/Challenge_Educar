<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRelations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->bigInteger('id_position')->unsigned()->after('id');
            $table->foreign('id_position')->references('id')->on('positions');
        });

        Schema::table('recharges', function (Blueprint $table) {
            $table->bigInteger('id_employee')->unsigned()->after('id');
            $table->foreign('id_employee')->references('id')->on('employees');
        });

        Schema::table('transfers', function (Blueprint $table) {
            $table->bigInteger('id_employee_transfers')->unsigned()->after('id');
            $table->foreign('id_employee_transfers')->references('id')->on('employees');
        });

        Schema::table('transfers', function (Blueprint $table) {
            $table->bigInteger('id_employee_receives')->unsigned()->after('id');
            $table->foreign('id_employee_receives')->references('id')->on('employees');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->dropForeign('employees_id_position_foreign');
        });

        Schema::table('recharges', function (Blueprint $table) {
            $table->dropForeign('recharges_id_employee_foreign');
        });

        Schema::table('transfers', function (Blueprint $table) {
            $table->dropForeign('transfers_id_employee_transfers_foreign');
        });

        Schema::table('transfers', function (Blueprint $table) {
            $table->dropForeign('transfers_id_employee_receives_foreign');
        });

    }
}
