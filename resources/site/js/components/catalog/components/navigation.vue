<template>

                <nav class="header-nav col">
                    <ul class="navigation">
                        <li v-for="(item, index) in nav">
                            <a :href="'#cat_' + item.id" class="text-orange-hover" v-smooth-scroll>{{item.title}}</a>
                        </li>
                    </ul>
                </nav>

</template>
<script>


    export default {
        data() {
            return {
                nav: [],
            }
        },
        methods: {
            getNav() {
                axios.get('api/catalog/nav')
                    .then((response) => {
                        this.nav = response.data;
                    })
            }
        },
        mounted() {
            this.getNav();
        }

    }
</script>
