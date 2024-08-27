export default {
    addToCart: ({ commit }, item) => commit("ADD_TO_CART", item),
    deleteFromCart: ({ commit }, item) => commit("DELETE_FROM_CART", item),
    toggleCart: ({ commit }) => commit("TOGGLE_CART"),
    removeItemFromCart: ({ commit }, item) => commit("REMOVE_ITEM_FROM_CART", item),
    clearCart: ({commit}) => commit('CLEAR_CART')
}
