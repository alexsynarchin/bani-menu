<template>

        <button type="button" class="button orange cart-button" @click.prevent="cartAction">
            <span>Корзина</span>
            <span class="cart-button-count">{{ TotalPositions }}</span>
        </button>

</template>
<script>
import { mapGetters, mapActions } from "vuex";
export default {
    name: "MinyCart",
    computed: {
        ...mapGetters(["TotalPositions"])
    },
    methods: {
        ...mapActions(['toggleCart']),
        cartAction() {
            if (this.$store.getters.UserId) {
                this.toggleCart();
            } else {
                this.$notify({type:'error', text: 'Вам нужно авторизоваться на сайта'});
            }
        },
    }
}
</script>
