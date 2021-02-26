<?php

use HDSSolutions\Finpar\Blueprints\BaseBlueprint as Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        // get schema builder
        $schema = DB::getSchemaBuilder();

        // replace blueprint
        $schema->blueprintResolver(fn($table, $callback) => new Blueprint($table, $callback));

        // create table
        $schema->create('products', function(Blueprint $table) {
            $table->id();
            $table->foreignTo('Company');
            $table->string('name');
            $table->string('code')->nullable();
            $table->string('url', 127)->unique()->nullable();
            $table->foreignTo('Type');
            $table->string('brief', 2048)->nullable();
            $table->text('description')->nullable();
            $table->foreignTo('File', 'image_id')->nullable();
            //
            $table->foreignTo('Brand')->nullable();
            $table->foreignTo('Model')->nullable();
            $table->foreignTo('Family')->nullable();
            $table->foreignTo('SubFamily')->nullable();
            $table->foreignTo('Line')->nullable();
            $table->foreignTo('Gama')->nullable();
            //
            $table->boolean('giftcard')->default(false);
            $table->unsignedInteger('stock_alert')->nullable();
            $table->amount('price')->nullable();
            $table->amount('price_reseller')->nullable();
            $table->enum('tax', [ 'ex', '05', '10', '05i', '10i' ])->default('10i');
            //
            $table->amount('weight', 6)->nullable();
            $table->amount('length', 6)->nullable();
            $table->amount('width', 6)->nullable();
            $table->amount('height', 6)->nullable();
            //
            $table->boolean('visible')->default(true);
            $table->priority()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('products');
    }

}
