const calculateObject = reducerFn => obj =>
    Object.values(obj).reduce(reducerFn, 0);

const calculateAmount = calculateObject((acc, { quantity, price }) => acc + quantity * price);

const calculateTotal = calculateObject((acc, { quantity }) => acc + quantity);

const copyFunc = (obj_1, obj_2, item) => {
    obj_2[item] = Object.assign({}, obj_1[item]);
    return obj_2;
};

const priceWithDivider = (price, divider) =>
{
    let multiplicator = divider * 0.001;
    return price * multiplicator;
}

export { calculateAmount, calculateTotal, copyFunc, priceWithDivider };
