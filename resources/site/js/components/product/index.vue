<template>
    <div class="product-item col-xl-3 col-md-4 col-sm-6">
        <div class="row gutters10 align-items-sm-center">
            <div class="item-img col-sm-12 col-auto">
                <img :src="product.preview" alt="">
            </div>
            <div class="product-content col-sm-12 col">
                <h3 class="product-title">{{product.title}}</h3>
                <div class="row gutters5 product-price-row align-items-center">
                    <div class="col product-price">
                        <p>{{product.price}}₽</p>
                    </div>
                    <div class="col-auto product-button">
                        <button type="button" class="button orange">В корзину</button>
                        <div class="product-count">
                            <span class="minus"></span>
                            <input type="text" value="1" class="count">
                            <span class="plus"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        props: {
            product: {
                type:Object
            }
        }
    }
</script>
