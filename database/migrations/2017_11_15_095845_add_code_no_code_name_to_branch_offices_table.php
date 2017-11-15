<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCodeNoCodeNameToBranchOfficesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('branchOffices',function(Blueprint $table){
            $table->string('codeNo')->unique();
            $table->string('codeName')->unique();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('branchOffices',function (Blueprint $table){
           $table->dropColumn('codeNo');
           $table->dropColumn('codeName');
        });
    }
}
