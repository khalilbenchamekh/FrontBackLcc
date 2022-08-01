import {call, put} from "redux-saga/effects";
import * as types from "../../../actions";
import {
    addInvoiceService, deleteInvoiceService,
    getInvoiceService,
    updateInvoiceService
} from "../../../services/crud/Charges/invoiceStatusServices";
import {getChargeToSelectSaga} from "./loadSaga";


export function* getInvoiceSaga(payload) {
    try {
        yield [
            put({type: types.SET_LOADING, payload: true})
        ];
        let response = yield call(getInvoiceService, payload);
        if (response.data) {
            yield [
                put({type: types.GET_INVOICE_STATUS_SUCCESS, response}),
                put({type: types.SET_LOADING, payload: false})
            ];
        }

    } catch (error) {
        yield [
            put({type: types.GET_INVOICE_STATUS_ERROR, error}),
            put({type: types.SET_LOADING, payload: false})
        ];
    }
}

export function* getInvoiceToSelectSaga(payload) {
    try {
        yield [
            put({type: types.SET_LOADING, payload: true})
        ];
        let response = yield call(getInvoiceService, payload);
        if (response.data) {
            yield [
                put({type: types.GET_INVOICE_STATUS_TO_SELECT_SUCCESS, response}),
                put({type: types.SET_LOADING, payload: false})
            ];
        }

    } catch (error) {
        yield [
            put({type: types.GET_INVOICE_STATUS_TO_SELECT_ERROR, error}),
            put({type: types.SET_LOADING, payload: false})
        ];
    }
}


export function* addInvoiceSaga(payload) {
    try {
        yield [
            put({type: types.SET_LOADING, payload: true})
        ];
        let response = yield call(addInvoiceService, payload);

        yield [
            put({type: types.ADD_INVOICE_STATUS_SUCCESS, response}),
            put({type: types.SET_LOADING, payload: false})
        ];
    } catch (error) {
        yield [
            put({type: types.ADD_INVOICE_STATUS_ERROR, error}),
            put({type: types.SET_LOADING, payload: false})
        ];
    }
}

export function* updateInvoiceSaga(payload) {
    try {
        yield [
            put({type: types.SET_LOADING, payload: true})
        ];
        let response = yield call(updateInvoiceService, payload);
        if (response.error) {
            yield [
                put({type: types.UPDATE_INVOICE_STATUS_ERROR, response: response.error}),
                put({type: types.SET_LOADING, payload: false})
            ];

        } else {
            yield [
                put({
                    type: types.UPDATE_INVOICE_STATUS_SUCCESS,
                    response:
                    response, id: payload.payload.id
                }),
                put({type: types.SET_LOADING, payload: false})
            ];
        }

    } catch (error) {
        yield [
            put({type: types.UPDATE_INVOICE_STATUS_ERROR, error}),
            put({type: types.SET_LOADING, payload: false})
        ];
    }
}

export function* deleteInvoiceSaga(payload) {
    try {
        yield [
            put({type: types.SET_LOADING, payload: true})
        ];
        let response = yield call(deleteInvoiceService, payload);
        if (response.error) {
            yield [
                put({type: types.DELETE_INVOICE_STATUS_ERROR, response: response.error}),
                put({type: types.SET_LOADING, payload: false})
            ];

        } else {
            yield [
                put({
                    type: types.DELETE_INVOICE_STATUS_SUCCESS,
                    id: payload.payload.id
                }),
                put({type: types.SET_LOADING, payload: false})
            ];
        }


    } catch (error) {
        yield [
            put({
                type: types.DELETE_INVOICE_STATUS_SUCCESS,
                id: payload.payload.id
            })
        ];
        yield put({type: types.DELETE_INVOICE_STATUS_ERROR, error});
    }
}



