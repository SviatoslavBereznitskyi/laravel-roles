<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoleTeamTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $connection = config('roles.connection');
        $table = config('roles.roleTeamTable');
        $rolesTable = config('roles.rolesTable');
        $teamsTable = config('roles.teamsTable');
        $tableCheck = Schema::connection($connection)->hasTable($table);

        if (!$tableCheck) {
            Schema::connection($connection)->create($table, function (Blueprint $table) use ($rolesTable, $teamsTable) {
                $table->increments('id')->unsigned();
                $table->integer('role_id')->unsigned()->index();
                $table->foreign('role_id')->references('id')->on($rolesTable)->onDelete('cascade');
                $table->unsignedBigInteger('team_id')->unsigned()->index();
                $table->foreign('team_id')->references('id')->on($teamsTable)->onDelete('cascade');
                $table->timestamps();
                $table->softDeletes();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $connection = config('roles.connection');
        $table = config('roles.roleUserTable');
        Schema::connection($connection)->dropIfExists($table);
    }
}
