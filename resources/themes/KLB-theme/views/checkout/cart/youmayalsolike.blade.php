<?php
    $relatedProducts = $product->related_products();
?>
<div class="widget-title not-before">
    <h3 class="box-title">
        <span class="title">
            <span>
                You May Also Like
            </span>
        </span>
    </h3>
</div>

@if ($relatedProducts->count())
    <div class="carousel-products vc-full-screen">
        <carousel-component
            slides-per-page="6"
            navigation-enabled="hide"
            pagination-enabled="hide"
            id="related-products-carousel"
            :slides-count="{{ sizeof($relatedProducts) }}">

            @foreach ($relatedProducts as $index => $relatedProduct)
                <slide slot="slide-{{ $index }}">
                    @include ('shop::products.list.card', [
                        'product' => $relatedProduct,
                        'addToCartBtnClass' => 'small-padding',
                    ])
                </slide>
            @endforeach
        </carousel-component>
    </div>

    <div class="carousel-products vc-small-screen">
        <carousel-component
            :slides-count="{{ sizeof($relatedProducts) }}"
            slides-per-page="2"
            id="related-products-carousel"
            navigation-enabled="hide"
            pagination-enabled="hide">

            @foreach ($relatedProducts as $index => $relatedProduct)
                <slide slot="slide-{{ $index }}">
                    @include ('shop::products.list.card', [
                        'product' => $relatedProduct,
                        'addToCartBtnClass' => 'small-padding',
                    ])
                </slide>
            @endforeach
        </carousel-component>
    </div>
@endif