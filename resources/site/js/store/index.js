
import getters from "./getters";
import actions from "./actions";
import mutations from "./mutations";
export default {
    state: {
        cart: [],
        TotalPositions: 0,
        Total: 0,
        ShowCart:false,
        userId: 0,
    },
    getters,
    actions,
    mutations,
}
