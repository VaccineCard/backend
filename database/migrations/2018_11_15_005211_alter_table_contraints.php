<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableContraints extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //Table users
        Schema::table('users', function (Blueprint $table) {
            $table->foreign('country_id')->references('id')->on('countries');
            $table->foreign('state_id')->references('id')->on('states');
        });

        //Table centers
        Schema::table('centers', function (Blueprint $table) {

            $table->foreign('state_id')->references('id')->on('states');
            $table->foreign('country_id')->references('id')->on('countries');
        });

        //Table animals
        Schema::table('animals', function (Blueprint $table) {

            $table->foreign('user_id')->references('id')->on('users');
        });

        //Table vaccinators
        Schema::table('vaccinators', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users');
        });
        //Table family_links
        Schema::table('family_links', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('family_id')->references('id')->on('users');
        });

        //Table vaccine_centers
        Schema::table('vaccine_centers', function (Blueprint $table) {
            $table->foreign('center_id')->references('id')->on('centers');
            $table->foreign('vaccine_id')->references('id')->on('vaccines');
        });

        //Table vaccinator_centers
        Schema::table('vaccinator_centers', function (Blueprint $table) {
            $table->foreign('center_id')->references('id')->on('centers');
            $table->foreign('vaccinator_id')->references('id')->on('vaccinators');
        });

        //Table vaccinator_vaccines
        Schema::table('vaccinator_vaccines', function (Blueprint $table) {
            $table->foreign('vaccinator_id')->references('id')->on('vaccinators');
            $table->foreign('vaccine_id')->references('id')->on('vaccines');
        });

        //Table vaccinator_vaccines
        Schema::table('user_vaccines', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('vaccinator_id')->references('id')->on('vaccinators');
            $table->foreign('vaccine_id')->references('id')->on('vaccines');
        });

        //Table states
        Schema::table('states', function (Blueprint $table) {
            $table->foreign('country_id')->references('id')->on('countries');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //Table users
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign('users_country_id_foreign');
            $table->dropForeign('users_state_id_foreign');
        });

        //Table centers
        Schema::table('centers', function (Blueprint $table) {

            $table->dropForeign('centers_country_id_foreign');
            $table->dropForeign('centers_state_id_foreign');
        });

        //Table animals
        Schema::table('animals', function (Blueprint $table) {
            $table->dropForeign('animals_user_id_foreign');
        });

        //Table vaccinators
        Schema::table('vaccinators', function (Blueprint $table) {
            $table->dropForeign('vaccinators_user_id_foreign');
        });
        //Table family_links
        Schema::table('family_links', function (Blueprint $table) {
            $table->dropForeign('family_links_user_id_foreign');
            $table->dropForeign('family_links_family_id_foreign');
        });

        //Table vaccine_centers
        Schema::table('vaccine_centers', function (Blueprint $table) {
            $table->dropForeign('vaccine_centers_center_id_foreign');
            $table->dropForeign('vaccine_centers_vaccines_id_foreign');
        });

        //Table vaccinator_centers
        Schema::table('vaccinator_centers', function (Blueprint $table) {
            $table->foreign('center_id')->references('id')->on('centers');
            $table->foreign('vaccinator_id')->references('id')->on('vaccinators');

            $table->dropForeign('vaccinator_centers_center_id_foreign');
            $table->dropForeign('vaccinator_centers_vaccinator_id_foreign');

        });

        //Table vaccinator_vaccines
        Schema::table('vaccinator_vaccines', function (Blueprint $table) {
            $table->dropForeign('vaccinator_vaccines_vaccinator_id_foreign');
            $table->dropForeign('vaccinator_vaccines_vaccine_id_foreign');
        });

        Schema::table('user_vaccines', function (Blueprint $table) {
            $table->dropForeign('user_vaccines_vaccinator_id_foreign');
            $table->dropForeign('user_vaccines_vaccine_id_foreign');
            $table->dropForeign('user_vaccines_user_id_foreign');
        });

        //Table states
        Schema::table('states', function (Blueprint $table) {
            $table->dropForeign('states_country_id_foreign');
        });
    }

}
