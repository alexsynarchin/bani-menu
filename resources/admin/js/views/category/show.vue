<template>
    <section class="page">
        <h1 class="page-title">
            {{category.title}}
        </h1>
        <el-tabs type="border-card" v-model="activeName">
            <el-tab-pane name="Products">
                <span slot="label"><i class="el-icon-s-grid"></i> Товары</span>
                <Products :categoryId="$route.params.categoryId"></Products>
            </el-tab-pane>
        </el-tabs>
    </section>
</template>
<script>
import Products from "@/admin/js/views/products/index.vue";
    export default {
        components: {Products},
        data() {
            return {
                category: {},
                activeName:'Products'
            }
        },
        methods: {
            getCategory() {
                axios.get('/api/admin/category/' + this.$route.params.categoryId)
                    .then((response) => {
                        this.category = response.data;
                    })
            }
        },
        mounted() {
            this.getCategory();
        }
    }
</script>
