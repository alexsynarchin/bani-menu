export default {
    cart: ({ cart }) => cart,
    Total: ({ Total }) => Total,
    TotalPositions: ({ TotalPositions }) => TotalPositions,
    ShowCart:  ({ ShowCart }) => ShowCart,
    getProductCartCount: (state) => (id) => {
        let count = 0;
        let index = state.cart.findIndex(cartItem => cartItem.id === id);
        if (index !== -1) {
            count = state.cart[index].quantity;
        }
        return count;
    },


};
