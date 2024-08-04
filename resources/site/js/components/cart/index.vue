<template>
    <div id="cart" :class="{'active':ShowCart}">
        <div class="cart-close" @click.prevent="toggleCart"></div>
        <div class="cart-inner">

            <div class="cart-products">

                <div class="cart-product" v-for="(item) in products">
                    <div class="row gutters5 align-items-center">
                        <div class="col-auto cart-product-image">
                            <img :src="item.preview" alt="">
                        </div>
                        <div class="col">
                            <h3 class="cart-product-title">{{item.tile}}</h3>
                        </div>
                        <div class="col-auto cart-product-remove">
                            <div class="product-remove" @click.prevent="removeItemFromCart(item.id)"></div>
                        </div>
                    </div>
                    <div class="cart-product-price-row row gutters5 align-items-center">
                        <div class="cart-product-price col">
                            <span>{{item.price}} ₽</span>
                        </div>
                        <div class="cart-product-count col-auto">
                            <div class="product-count">
                                <span class="minus" @click.prevent = "addToBasket('minus', item)"></span>
                                <input type="text" v-model="item.qt" class="count">
                                <span class="plus" @click.prevent = "addToBasket('plus', item)"></span>
                            </div>
                        </div>
                    </div>
                </div>




            </div><!-- cart-products -->

            <div class="cart-final-data">

                <p class="cart-total">Итого: <span>{{Total}} ₽</span></p>

                <div class="form-group">
                    <input type="text" name="" value="" placeholder="Номер столика" class="form-control">
                </div>

                <div class="form-group">
                    <textarea name="" rows="5" placeholder="Комментарий" class="form-control"></textarea>
                </div>

                <div class="cart-button">
                    <button type="button" class="button orange">Оформить</button>
                </div>

            </div>

        </div>
    </div>
</template>
<script>
import {mapActions, mapGetters} from "vuex";

 export default {
     data() {
         return {
             active:false,
             products: {},

         }
     },
     watch: {
         cart() {
             this.products = this.cart;

         }
     },
     computed: {

         ...mapGetters(["ShowCart", "cart", "TotalPositions", "Total"]),



     },
     methods: {
        ...mapActions(['toggleCart', 'removeItemFromCart','addToCart', 'deleteFromCart']),
         addToBasket(type, product) {

                 if(type === 'plus') {
                     this.addToCart(product);
                     this.count ++;
                 } else {
                     this.count --;
                     this.deleteFromCart(product.id);
                 }

         }
     },
     mounted() {
         this.products = this.cart;
     }
 }
</script>
