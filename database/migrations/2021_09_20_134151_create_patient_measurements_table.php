<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientMeasurementsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('patient_measurements', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->double('value');
			$table->timestamp('measured_at');
			$table->unsignedBigInteger('patient_id');
			$table->unsignedBigInteger('measurement_type_id');
			$table->timestamps();
			$table->softDeletes();
			$table->foreign('patient_id')->references('id')->on('patients');
			$table->foreign('measurement_type_id')->references('id')->on('measurement_types');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('patient_measurements');
	}
}
