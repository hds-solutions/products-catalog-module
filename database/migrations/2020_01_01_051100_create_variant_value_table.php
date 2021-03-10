<?php

use HDSSolutions\Finpar\Blueprints\BaseBlueprint as Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateVariantValueTable extends Migration {
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
        $schema->create('variant_value', function(Blueprint $table) {
            $table->asPivot();
            $table->foreignTo('Company');
            $table->foreignTo('Variant');
            $table->foreignTo('Option');
            $table->primary([ 'variant_id', 'option_id' ]);
            //
            $table->foreignTo('OptionValue')->nullable();
            $table->string('value')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('variant_value');
    }
}
