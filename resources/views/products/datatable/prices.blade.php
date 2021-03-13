<div>
    {product.prices}
        {price.code} <b>{currency:null,price.pivot.price,price.decimals}</b>
    {/product.prices}
    &nbsp;
</div>
<div class="small">
    {product.variants}
        <div class="row">
            <div class="col">
                {variant.prices}
                    {price.code} <b>{currency:null,price.pivot.price,price.decimals}</b>
                {/variant.prices}
            </div>
        </div>
    {/product.variants}
</div>