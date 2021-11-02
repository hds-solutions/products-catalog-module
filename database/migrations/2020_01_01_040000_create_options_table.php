<?php

use HDSSolutions\Laravel\Blueprints\BaseBlueprint as Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateOptionsTable extends Migration {

    public function up() {
        // get schema builder
        $schema = DB::getSchemaBuilder();

        // replace blueprint
        $schema->blueprintResolver(fn($table, $callback) => new Blueprint($table, $callback));

        // create table
        $schema->create('options', function(Blueprint $table) {
            $table->id();
            $table->foreignTo('Company');
            $table->string('name', 255);
            $table->string('label')->nullable();
            $table->enum('value_type', [ 'text', 'number', 'boolean', 'choice', 'color', 'image' ])->default('text');
            $table->boolean('show')->default(false);
        });
    }

    public function down() {
        Schema::dropIfExists('options');
    }
}
