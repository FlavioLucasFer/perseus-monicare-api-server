<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ExchangeAgeAttrTypeToDate extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('caregivers', function (Blueprint $table) {
			$table->date('age')->change();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('caregivers', function (Blueprint $table) {
			$table->integer('age')->change();
		});
	}
}
