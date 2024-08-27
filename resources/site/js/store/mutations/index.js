import { calculateAmount, calculateTotal, copyFunc } from "@/site/js/functions";
export default {
    ADD_TO_CART: (state, item) => {
        state.TotalPositions++;
        let index = state.cart.findIndex(cartItem => cartItem.id === item.id);
        if(index === -1) {
            let stateItem = { ...item };
            stateItem.quantity = 1;
            state.cart.push(stateItem);
        } else {
            state.cart[index].quantity++;
        }

        state.Total = calculateAmount(state.cart);

    },
    DELETE_FROM_CART: (state, item) => {
        let index = state.cart.findIndex(cartItem => cartItem.id === item);
        if(state.cart[index].quantity === 1) {
            state.cart.splice(index,1)
        } else {
            state.cart[index].quantity--
        }

        state.Total = calculateAmount(state.cart);
        state.TotalPositions = calculateTotal(state.cart);
    },
    REMOVE_ITEM_FROM_CART:(state, item) => {
        let index = state.cart.findIndex(cartItem => cartItem.id === item);
        state.cart.splice(index,1);
        state.Total = calculateAmount(state.cart);
        state.TotalPositions = calculateTotal(state.cart);
    },
    TOGGLE_CART: (state) => {
        state.ShowCart = !state.ShowCart;
    },
    CLEAR_CART: (state) => {
        state.cart = [];
        state.Total = calculateAmount(state.cart);
        state.TotalPositions = calculateTotal(state.cart);
    }
}
