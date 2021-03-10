<?php

use HDSSolutions\Finpar\Blueprints\BaseBlueprint as Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateFamilyOptionTable extends Migration {
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
        $schema->create('family_option', function(Blueprint $table) {
            $table->asPivot();
            $table->foreignTo('Company');
            $table->foreignTo('Family');
            $table->foreignTo('Option');
            $table->primary([ 'family_id', 'option_id' ]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('family_option');
    }

}
