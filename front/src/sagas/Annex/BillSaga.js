import * as types from "../../actions";
import { put, call } from 'redux-saga/effects';
import { getBillService, getClientToSelectInBillService } from "../../services/annex/billServices";

export function* getBillSaga(payload) {
    try {
        let response = yield call(getBillService, payload);

    } catch (error) {
        yield put({ type: types.PRINT_BILL_ERROR, error });
    }
}

export function* getClientToSelectInBillSaga(payload) {
    try {
        yield [
            put({ type: types.SET_LOADING, payload: true })
        ];

        let response = yield call(getClientToSelectInBillService, payload);
        if (response) {
            if (response.data) {
                let data = response.data;
                yield [
                    put({ type: types.CLIENT_BILL_SELECT_SUCCESS, response: data }),
                ];
            }
        }
        yield [
            put({ type: types.SET_LOADING, payload: false })
        ];
    } catch (error) {
        yield [
            put({ type: types.CLIENT_BILL_SELECT_ERROR, error }),
            put({ type: types.SET_LOADING, payload: false })
        ];
    }
}
