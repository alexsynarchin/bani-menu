<template>

        <div :class="{'container':category.parent_id === 0}">
            <h2 class="caption" v-if="category.parent_id === 0">{{category.title}}</h2>
            <h3 class="subcaption" v-else>{{category.title}}</h3>
            <div class="row gutters20">
                <product v-for="(product, index) in category.products"
                    :key="index"
                     :product = "product"
                ></product>
            </div>
            <category v-if="category.children.length > 0"
                v-for="(item, index) in category.children"
                  :category="item"
                  :key="index"
            ></category>
        </div>


</template>
<script>
    import product from "../product/index.vue";
    export default {
        name: "category",
        components: {product},
        props: {
            category: {
                type: Object
            }
        }
    }
</script>
