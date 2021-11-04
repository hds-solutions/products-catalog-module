<?php

namespace HDSSolutions\Laravel\Imports;

use Closure;
use HDSSolutions\Laravel\Models\Brand;
use HDSSolutions\Laravel\Models\Currency;
use HDSSolutions\Laravel\Models\Family;
use HDSSolutions\Laravel\Models\Gama;
use HDSSolutions\Laravel\Models\Line;
use HDSSolutions\Laravel\Models\Option;
use HDSSolutions\Laravel\Models\PriceChange;
use HDSSolutions\Laravel\Models\PriceChangeLine;
use HDSSolutions\Laravel\Models\Product;
use HDSSolutions\Laravel\Models\SubFamily;
use HDSSolutions\Laravel\Models\Type;
use HDSSolutions\Laravel\Models\Variant;
use HDSSolutions\Laravel\Models\VariantValue;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Row;
use Maatwebsite\Excel\Concerns\RemembersChunkOffset;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ProductsImporter implements OnEachRow, WithChunkReading, WithHeadingRow, WithMultipleSheets {
    use RemembersChunkOffset;

    public function __construct(
        private int $sheet,
        private Collection $matches,
        private Collection $customs,
        private array|null $current_row = null,
    ) {
        // log matches
        info('Matches: '.json_encode($this->matches));
        info('Customs: '.json_encode($this->customs));
    }

    public function sheets():array {
        return [ $this->sheet => $this ];
    }

    public function onRow(Row $row) {
        // register row on current
        $this->current_row = $row->toArray();

        // find product by name or create a new one
        if (!($product = Product::firstOrNew([ 'name' => $this->match('name') ]))->exists) {
            // assign Type to Product
            $product->type()->associate(
                // find Type of create a new one
                $type = Type::firstOrCreate([ 'name' => $this->match('type_id') ])
            );
            // log resource creation
            if ($type->wasRecentlyCreated) logger(__('Created new Type #:id ":name"', $type->attributesToArray()));

            // check if brand is specified and has value
            if ($this->matches->has('brand_id') && $this->match('brand_id')) {
                // assign Brand to Product
                $product->brand()->associate(
                    // find Brand of create a new one
                    $brand = Brand::firstOrCreate([ 'name' => $this->match('brand_id') ])
                );
                // log resource creation
                if ($brand->wasRecentlyCreated) logger(__('Created new Brand #:id ":name"', $brand->attributesToArray()));

                // check if model is specified and has value
                if ($this->matches->has('model_id') && $this->match('model_id')) {
                    // assign Model to Product
                    $product->model()->associate(
                        // find Model of create a new one
                        $model = Model::firstOrCreate([ 'name' => $this->match('model_id'), 'brand_id' => $brand->id ])
                    );
                    // log resource creation
                    if ($model->wasRecentlyCreated) logger(__('Created new Model #:id ":name"', $model->attributesToArray()));
                }
            }

            // check if family is specified and has value
            if ($this->matches->has('family_id') && $this->match('family_id')) {
                // assign Family to Product
                $product->family()->associate(
                    // find Family of create a new one
                    $family = Family::firstOrCreate([ 'name' => $this->match('family_id') ])
                );
                // log resource creation
                if ($family->wasRecentlyCreated) logger(__('Created new Family #:id ":name"', $family->attributesToArray()));

                // check if sub_family is specified and has value
                if ($this->matches->has('sub_family_id') && $this->match('sub_family_id')) {
                    // assign SubFamily to Product
                    $product->subFamily()->associate(
                        // find SubFamily of create a new one
                        $sub_family = SubFamily::firstOrCreate([ 'name' => $this->match('sub_family_id'), 'family_id' => $family->id ])
                    );
                    // log resource creation
                    if ($sub_family->wasRecentlyCreated) logger(__('Created new SubFamily #:id ":name"', $sub_family->attributesToArray()));
                }
            }

            // check if line is specified and has value
            if ($this->matches->has('line_id') && $this->match('line_id')) {
                // assign Line to Product
                $product->line()->associate(
                    // find Line of create a new one
                    $line = Line::firstOrCreate([ 'name' => $this->match('line_id') ])
                );
                // log resource creation
                if ($line->wasRecentlyCreated) logger(__('Created new Line #:id ":name"', $line->attributesToArray()));

                // check if gama is specified and has value
                if ($this->matches->has('gama_id') && $this->match('gama_id')) {
                    // assign Gama to Product
                    $product->subFamily()->associate(
                        // find Gama of create a new one
                        $gama = Gama::firstOrCreate([ 'name' => $this->match('gama_id'), 'line_id' => $line->id ])
                    );
                    // log resource creation
                    if ($gama->wasRecentlyCreated) logger(__('Created new Gama #:id ":name"', $gama->attributesToArray()));
                }
            }
        }

        // save product data
        if (!$product->save()) {
            logger($product->errors());
            return false;
        }
        // log resource creation
        if ($product->wasRecentlyCreated) info(__('Imported Product #:id ":name"', $product->attributesToArray()));

        // find variant by SKU or create a new one
        if (!($variant = $product->variants()->firstOrNew([ 'sku' => $this->match('sku') ]))->exists) {
            // check if SKU is already in use
            $append = 1; while (Variant::where('sku', $this->match('sku').($append > 1 ? " #$append" : ''))->first()) $append++;
            // replace Variant SKU
            if ($append > 1) $variant->fill([ 'sku' => $this->match('sku').' #'.$append ]);
            // link variant with product
            $variant->product()->associate( $product );
        }

        // save variant data
        if (!$variant->save())
            // show variant errors on log
            return error( $variant->errors() );

        // log resource creation
        if ($variant->wasRecentlyCreated) info(__('Imported Variant #:id ":sku"', $variant->attributesToArray()));

        // process custom fields
        foreach ($this->customs as $relation => $fields) {

            foreach ($fields as $custom_field) {
                // ignore current row doesn't has value on custom field
                if (!($value = $this->custom($relation, $custom_field))) continue;

                // check if product has relation
                if ($product->{$relation} === null) {
                    info(__('Product #:id ":name" doesn\'t have :relation relation to add ":custom_field" custom field',
                        compact('relation', 'custom_field') + $product->attributesToArray()));
                    // ignore line
                    continue;
                }

                // find existing custom field by name or label
                if (($option = Option::where([ 'name' => $custom_field ])->orWhere([ 'label' => $custom_field ])
                    // create a new one if not exists
                    ->firstOrCreate([
                        'value_type'    => Option::VALUE_TYPE_Choice,
                        'name'          => __('Custom :custom_field field for Product.:relation ":name"', compact('custom_field', 'relation') + [ 'name' => $product->$relation->name ]),
                        'label'         => $custom_field,
                    ]))
                    // check if option is new
                    ->wasRecentlyCreated) {

                    logger(__('Created new Option #:id ":name" for Product.:relation ":relation_name"', $option->attributesToArray() + [
                        'relation'      => $relation,
                        'relation_name' => $product->$relation->name,
                    ]));

                    // link option to relation
                    $product->$relation->options()->attach( $option );
                }

                // get option vas value or create a new one
                if (($option_value = $option->values()->firstOrCreate([ 'value' => $value ]))
                    // check if OptionValue is new
                    ->wasRecentlyCreated) {

                    logger(__('Created new OptionValue #:id ":value" on Option #:option_id ":option_name"', $option_value->attributesToArray() + [
                        'option_id'     => $option->id,
                        'option_name'   => $option->name,
                    ]));
                }

                // create new VariantValue
                $variant_value = VariantValue::create([
                    'variant_id'        => $variant->id,
                    'option_id'         => $option->id,
                    'option_value_id'   => $option_value->id,
                ]);

                logger(__('Assigned VariantValue with value ":value" on Variant #:id ":sku"', $variant->attributesToArray() + [
                    'value' => $option_value->value,
                ]));

            }
        }
    }

    public function chunkSize():int { return 1000; }

    private function match(string $field):?string {
        return $this->get(fn() => $this->matches->get($field));
    }

    private function custom(string $relation, string $field):?string {
        return $this->get(fn() => $field);
    }

    private function get(Closure $finder):?string {
        // get row column based on field ID match
        $value = $this->current_row[ $finder() ] ?? null;
        // return value or null
        return $value !== null ? trim($value) : null;
    }
}
