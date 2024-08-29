<template>
    <section>
        <header>
            <div class="container">
                <div class="row align-items-center">
                    <navigation></navigation>
                    <div class="header-button col-md-auto">
                        <profile></profile>
                        <miny-cart></miny-cart>
                    </div>
                </div>

            </div>

        </header>
        <div class="start"></div>

        <section class="pt-small pb-big" :id="'cat_'+ category.id" v-for="(category, index) in catalog"
                 :key="index">
            <category
                :category="category"

            ></category>
        </section>

    <cart ref="cart"></cart>
    </section>
</template>
<script>
import navigation from "./components/navigation.vue";
import minyCart from "@/site/js/components/cart/components/minyCart.vue";
import category from "../category/index.vue";
import cart from '@/site/js/components/cart'
import profile from "@/site/js/components/profile/index.vue";
    export default {
        components: {navigation, category, minyCart,cart, profile},
        data() {
            return {
                catalog: [],
                basket: {
                    products: []
                },
            }
        },
        methods: {
            getCatalog() {
                axios.get('/api/catalog')
                    .then((response) => {
                        this.catalog = response.data;
                    })
            },
            addToBasket(data) {

            }
        },
        mounted() {
            this.getCatalog();
        }
    }
</script>
