<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDashboardColumnToUserRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('user_roles', 'dashboard_access')) {
            Schema::table('user_roles', function (Blueprint $table) {
                $table->boolean('dashboard_access')->default(false)->after('permissions');
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
        if (Schema::hasColumn('user_roles', 'dashboard_access')) {
            Schema::table('user_roles', function (Blueprint $table) {
                $table->dropColumn('dashboard_access');
            });
        }
    }
}
