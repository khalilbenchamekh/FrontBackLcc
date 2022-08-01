import * as types from "./index";

export const getInvoiceStatusAction = (token) => {
    return {
        type: types.GET_INVOICE_STATUS,
        token
    }
};
export const getInvoiceStatusToSelectAction = (token) => {
    return {
        type: types.GET_INVOICE_STATUS_TO_SELECT,
        token
    }
};

export const addInvoiceStatusAction = (token, obj) => {
    return {
        type: types.ADD_INVOICE_STATUS,
        payload: {token: token, obj: obj}
    }
};
export const updateInvoiceStatusAction = (token, obj, id, index) => {
    return {
        type: types.UPDATE_INVOICE_STATUS,
        payload: {
            token: token, id: id,
            index: index,
            obj: obj
        }
    }
};


export const deleteInvoiceStatusAction = (token, obj, id) => {
    return {
        type: types.DELETE_INVOICE_STATUS,
        payload: {token: token, id: id, obj: obj}
    }
};






