<template>
    <div id="cart" :class="{'active':ShowCart}">

        <div class="cart-close" @click.prevent="toggleCart"></div>
        <div class="cart-inner">

            <div class="cart-products">

                <div class="cart-product" v-for="(item) in products">
                    <div class="row gutters5 align-items-center">
                        <div class="col-auto cart-product-image">
                            <img :src="item.preview" alt="" v-if="item.preview">
                            <img src="/assets/images/no-image.svg" v-else>
                        </div>
                        <div class="col">
                            <h3 class="cart-product-title">{{item.title}}</h3>
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
                                <input type="text" v-model="item.quantity" class="count">
                                <span class="plus" @click.prevent = "addToBasket('plus', item)"></span>
                            </div>
                        </div>
                    </div>
                </div>




            </div><!-- cart-products -->

            <div class="cart-final-data">

                <p class="cart-total">Итого: <span>{{Total}} ₽</span></p>

                <div class="form-group">

                    <v-select placeholder="Номер столика" v-model="table" label="Table" :options="tables"></v-select>
                </div>

                <div class="form-group">
                    <textarea v-model="comment" name="" rows="5" placeholder="Комментарий" class="form-control"></textarea>
                </div>

                <div class="cart-button">
                    <button type="button" class="button orange" @click.prevent="saveOrder">Оформить</button>
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
            tables:[],
             table: null,
             comment: '',
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
        ...mapActions(['toggleCart', 'removeItemFromCart','addToCart', 'deleteFromCart', 'clearCart']),
         addToBasket(type, product) {

                 if(type === 'plus') {
                     this.addToCart(product);
                     this.count ++;
                 } else {
                     this.count --;
                     this.deleteFromCart(product.id);
                 }

         },
         getTables() {
            axios.get('/api/get-open-tables')
                .then((response) => {
                    this.tables = response.data;
                })
                .catch((error) => {

                })
         },
         saveOrder() {
            if(this.products.length === 0) {
                this.$notify({type: 'error', text: 'Добавьте товары в корзину'})
            } else if(!this.table) {
                this.$notify({type: 'error', text: 'Выберите открытый стол'})
            } else {
                axios.post('/api/save-order', {table:this.table, products: this.products,
                    comment:this.comment, amount: this.Total
                })
                    .then((response) => {
                        this.$notify({type:'success', text: 'Заказ оформлен'});
                       this.clearCart();
                       this.products = [];

                    })
                    .catch((error) => {

                    })
            }


         },
     },
     mounted() {
         this.products = this.cart;
         this.getTables();
     }
 }
</script>
