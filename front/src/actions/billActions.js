import * as types from "./index";

export const getBillAction = (token, obj) => {
    return {
        type: types.PRINT_BILL,
        payload: {
            token: token,
            obj: obj
        }
    }
};

export const getClientToSelectInBill = (token) => {
    return {
        type: types.CLIENT_BILL_SELECT,
        token: token,
    }
};

