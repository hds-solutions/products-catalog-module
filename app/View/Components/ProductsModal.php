<?php

namespace HDSSolutions\Laravel\View\Components;

use HDSSolutions\Laravel\Models\Brand;
use HDSSolutions\Laravel\Models\Family;
use HDSSolutions\Laravel\Models\Line;
use HDSSolutions\Laravel\Models\Type;
use HDSSolutions\Laravel\DataTables\Modals\ProductsDataTable as DataTable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\Component;

class ProductsModal extends Component {

    public function __construct(
        public DataTable $dataTable,

        public Collection $types,
        public Collection $brands,
        public Collection $families,
        public Collection $lines,
    ) {
        $this->types = Type::ordered()->sold()->get();
        $this->brands = Brand::with([ 'models' ])->ordered()->get()
            ->transform(fn($brand) => $brand
                // override loaded models, add relation to parent manually
                ->setRelation('models', $brand->models->transform(fn($model) => $model
                    // set Model.brand relation manually to avoid more queries
                    ->setRelation('brand', $brand)
                ))
            );
        $this->families = Family::with([ 'subFamilies' ])->ordered()->get()
            ->transform(fn($family) => $family
                // override loaded subFamilies, add relation to parent manually
                ->setRelation('subFamilies', $family->subFamilies->transform(fn($subFamily) => $subFamily
                    // set SubFamily.family relation manually to avoid more queries
                    ->setRelation('family', $family)
                ))
            );
        $this->lines = Line::with([ 'gamas' ])->ordered()->get()
            ->transform(fn($line) => $line
                // override loaded gamas, add relation to parent manually
                ->setRelation('gamas', $line->gamas->transform(fn($gama) => $gama
                    // set Gama.line relation manually to avoid more queries
                    ->setRelation('line', $line)
                ))
            );
    }

    public function render() {
        return fn($data) => $this->dataTable->render('products-catalog::components.products.modal', $data)->render();
    }
}
