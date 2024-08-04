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

                        <button v-if="!showAddToBasket" type="button"
                                class="button orange"
                                @click.prevent="showAddToBasket=true">В корзину</button>
                        <div v-if="showAddToBasket" class="product-count" style="display: block">
                            <span class="minus" @click.prevent = "addToBasket('minus')"></span>
                            <input type="text" v-model="count" class="count">
                            <span class="plus" @click.prevent = "addToBasket('plus')"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import { mapActions, mapGetters } from "vuex";
    export default {
        props: {
            product: {
                type:Object
            }
        },
        computed: {
            ...mapGetters(['getProductCartCount']),


        },
        watch: {
            '$store.state.TotalPositions': function() {
                this.count = this.getProductCartCount(this.product.id);
            }
        },
        data() {
            return {
                showAddToBasket: false,
                count:0,

            }
        },
        methods: {
            ...mapActions(['addToCart', 'deleteFromCart']),
            addToBasket(type) {
                if(type === 'minus' && this.getProductCartCount === 0) {

                } else {
                    if(type === 'plus') {
                        this.addToCart(this.product);

                    } else {

                        this.deleteFromCart(this.product.id);
                    }
                    //this.$store.dispatch('addToCart', this.product)
                    //this.add.addToCart(this.product)
                }


            }
        },
        mounted() {
            this.count = this.getProductCartCount(this.product.id);
        }
    }
</script>
