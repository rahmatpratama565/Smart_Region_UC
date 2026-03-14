<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

public function up(): void
{

Schema::table('login_logs', function (Blueprint $table) {

$table->integer('attempt_count')->default(0)->after('user_agent');

$table->boolean('blocked')->default(false)->after('attempt_count');

});

}

public function down(): void
{

Schema::table('login_logs', function (Blueprint $table) {

$table->dropColumn('attempt_count');

$table->dropColumn('blocked');

});

}

};