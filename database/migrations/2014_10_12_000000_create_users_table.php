<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
					$table->bigIncrements('id');
					$table->string('name', 150);
					$table->string('login', 50)->unique();
					$table->string('password');
					$table->char('cpf', 14)->unique();
					$table->char('phone', 15);
					$table->char('type', 2)
						->comment('AD = Admin | PT = Patient | DC = Doctor | CG = Caregiver | HP = Healthcare Professional');
					$table->enum('status', ['A', 'I'])->default('A')
						->comment('A = Active | I = Inactive');
					$table->rememberToken();
					$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
