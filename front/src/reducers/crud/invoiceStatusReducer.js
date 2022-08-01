import * as types from "../../actions";
import { updateObjectInArray} from "../../utils";

export default function (state = {
    error: '',
    invoiceStatus: [],
}, action) {
    const response = action.response;
    switch (action.type) {
        case types.GET_INVOICE_STATUS_SUCCESS:
            return {...state, invoiceStatus: response.data};
        case types.GET_INVOICE_STATUS_ERROR:
            return {
                ...state,
                error:  response.error
            };
        case types.ADD_INVOICE_STATUS_SUCCESS:
            return {
                ...state,
                invoiceStatus: state.invoiceStatus.concat(response.data)
            };
        case types.ADD_INVOICE_STATUS_ERROR:
            return {
                ...state,
                error:  response.error

            };
        case types.UPDATE_INVOICE_STATUS_SUCCESS:
            return {
                ...state,
                invoiceStatus: updateObjectInArray(state.invoiceStatus, response.data, action.id)
            };
        case types.DELETE_INVOICE_STATUS_SUCCESS:
            return {
                ...state,
                invoiceStatus : state.invoiceStatus.filter( (item, index) => index !== action.id)
            };

        case types.DELETE_INVOICE_STATUS_ERROR:
            return {
                ...state,
                error:  response.error
            };

        default:
            return state;
    }
};
