<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->dateTime('notBefore')   // cert valid times
                  ->nullable();
            $table->dateTime('notAfter')    // cert valid times
                  ->nullable();
            $table->json('error')           // wtf is a problem document
                  ->nullable();
            $table->json('authorizationUrls'); // list of subject authz urls
            $table->string('finalizeUrl');     // URL to call to sign the csr after authZ
            $table->string('certificateUrl')   // URL to call to get the cert after signing
                  ->nullable();
            $table->timestamps();
            $table->softDeletes();          // dont throw anything away
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
