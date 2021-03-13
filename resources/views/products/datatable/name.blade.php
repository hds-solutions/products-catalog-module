<div>{product.name}</div>
<div class="small">
    {product.variants}
        <div class="row">
            <span href="{{ route('backend.variants.edit', 'variant.id') }}"
                class="col-4 text-primary text-decoration-none">{variant.sku}</span>
            <div class="col">
                {variant.values}
                    {value.option.name}: <b>{value.option_value.value}</b>
                {/variant.values}
            </div>
        </div>
    {/product.variants}
</div>