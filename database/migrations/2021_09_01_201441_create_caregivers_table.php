<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCaregiversTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('caregivers', function (Blueprint $table) {
					$table->unsignedBigInteger('id')->primary();
					$table->unsignedBigInteger('patient_id');
					$table->integer('age');
					$table->char('kinship', 2)->comment('MT = Mother | FT = Father | CT = Custodian');
					$table->string('email')->nullable();
					$table->foreign('id')->references('id')->on('users');
					$table->foreign('patient_id')->references('id')->on('patients');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('caregivers');
    }
}
