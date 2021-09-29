<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class NewFieldsMeasurementTypes extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('measurement_types', function (Blueprint $table) {
			$table->double('optimum');
			$table->double('highest');
			$table->double('lowest');
			$table->double('max_border');
			$table->double('min_border');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('measurement_types', function (Blueprint $table) {
			$table->dropColumn([
				'optimum',
				'highest',
				'lowest',
				'max_border',
				'min_border',
			]);
		});
	}
}
