<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLastNameToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('last_name')->nullable()->after('name');
            $table->renameColumn('name', 'first_name');
            $table->string('collage_name')->nullable()->after('date_of_birth');
            $table->string('total_profile_views')->nullable()->after('collage_name');
            $table->string('interested_video_language')->nullable();
            $table->string('interested_video_category');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
}
