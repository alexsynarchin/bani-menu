<template>

        <button type="button" class="button orange cart-button" @click.prevent="toggleCart">
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
        ...mapActions(['toggleCart'])
    }
}
</script>
