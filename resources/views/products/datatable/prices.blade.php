<div>
    {product.prices}<span class="mr-2">{price.code} <b>{currency:null,price.pivot.price,price.decimals}</b></span>{/product.prices}
    &nbsp;
</div>
<div class="small">
    {product.variants}
        <div class="row">
            <div class="col">
                {variant.prices}<span class="mr-2">{price.code} <b>{currency:null,price.pivot.price,price.decimals,false}</b></span>{/variant.prices}
                &nbsp;
            </div>
        </div>
    {/product.variants}
</div>
