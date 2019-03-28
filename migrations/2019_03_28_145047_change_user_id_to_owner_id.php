<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeUserIdToOwnerId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('webhooks', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });

        Schema::table('webhooks', function (Blueprint $table) {
            $table->renameColumn('user_id', 'owner_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('webhooks', function (Blueprint $table) {
            $table->renameColumn('owner_id', 'user_id');
        });
        Schema::table('webhooks', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users');
        });
    }
}
