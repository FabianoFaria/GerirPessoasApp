<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePessoasTable extends Migration
{
    /**
     * The database connection that should be used by the migration.
     *
     * @var string
     */
    protected $connection = 'pgsql';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('pessoas');

        Schema::create('pessoas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('pessoa_nome', 100);
            $table->string('status', 1);
            $table->timestamps($precision = 0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pessoas');
    }
}
