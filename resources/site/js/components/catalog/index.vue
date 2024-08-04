<template>
    <section>
        <header>
            <div class="container">
                <div class="row align-items-center">
                    <navigation></navigation>
                    <div class="header-button col-md-auto">
                        <button type="button" class="button orange cart-button">
                            <span>Корзина</span>
                            <span class="cart-button-count">22</span>
                        </button>
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


    </section>
</template>
<script>
import navigation from "./components/navigation.vue";
import category from "../category/index.vue";
    export default {
        components: {navigation, category},
        data() {
            return {
                catalog: [],
            }
        },
        methods: {
            getCatalog() {
                axios.get('/api/catalog')
                    .then((response) => {
                        this.catalog = response.data;
                    })
            }
        },
        mounted() {
            this.getCatalog();
        }
    }
</script>
