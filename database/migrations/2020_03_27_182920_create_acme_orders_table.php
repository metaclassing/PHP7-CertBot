<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAcmeOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('acme_orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('account_id')   // linkage to account id owning them
                  ->unsigned();
            $table->string('status');       // enum values like new, pending, valid
            $table->dateTime('expires');    // order expiration time
            $table->json('identifiers');    // need a good description of this
            $table->dateTime('notBefore');  // cert valid times
            $table->dateTime('notAfter');   // cert valid times
            $table->json('error');          // wtf is a problem document
            $table->json('authorizations'); // list of subject authz?
            $table->string('finalize');     // URL to call to sign the csr after authZ
            $table->string('certificate');  // URL to call to get the cert after signing
            $table->timestamps();
            $table->softDeletes();          // dont throw anything away

            $table->foreign('account_id')   // add the foreign key linkage to acme account
                  ->references('id')
                  ->on('acme_accounts');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('acme_orders');
    }
}