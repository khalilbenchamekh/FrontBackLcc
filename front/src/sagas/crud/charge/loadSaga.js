import { call, put } from "redux-saga/effects";
import * as types from "../../../actions";
import {
    addChargeService,
    deleteChargeService,
    getChargeService,
    updateChargeService
} from "../../../services/crud/Charges/ChargeService";



export function* getChargeSaga(payload) {
    try {
        yield [
            put({ type: types.SET_LOADING, payload: true })
        ];
        let response = yield call(getChargeService, payload);

        yield [
            put({ type: types.GET_CHARGES_SUCCESS, response }),
            put({ type: types.SET_LOADING, payload: false })
        ];
    } catch (error) {
        yield [
            put({ type: types.GET_CHARGES_ERROR, error }),
            put({ type: types.SET_LOADING, payload: false })
        ];
    }
}
export function* addChargeSaga(payload) {
    try {
        yield [
            put({ type: types.SET_LOADING, payload: true })
        ];
        let response = yield call(addChargeService, payload);

        yield [
            put({ type: types.ADD_CHARGES_SUCCESS, response }),
            put({ type: types.SET_LOADING, payload: false })
        ];
    } catch (error) {
        yield [
            put({ type: types.ADD_CHARGES_ERROR, error }),
            put({ type: types.SET_LOADING, payload: false })
        ];
    }
}
export function* updateChargeSaga(payload) {
    try {
        yield [
            put({ type: types.SET_LOADING, payload: true })
        ];
        let response = yield call(updateChargeService, payload);
        if (response.error) {
            yield [
                put({ type: types.UPDATE_CHARGES_ERROR, response: response.error }),
                put({ type: types.SET_LOADING, payload: false })
            ];

        } else {
            yield [
                put({
                    type: types.UPDATE_CHARGES_SUCCESS,
                    response:
                        response, id: payload.payload.index
                }),
                put({ type: types.SET_LOADING, payload: false })
            ];
        }

    } catch (error) {
        yield [
            put({ type: types.UPDATE_CHARGES_ERROR, error }),
            put({ type: types.SET_LOADING, payload: false })
        ];
    }
}

export function* deleteChargeSaga(payload) {
    try {
        yield [
            put({ type: types.SET_LOADING, payload: true })
        ];
        let response = yield call(deleteChargeService, payload);
        if (response.error) {
            yield [
                put({ type: types.DELETE_CHARGES_ERROR, response: response.error }),
                put({ type: types.SET_LOADING, payload: false })
            ];

        } else {
            yield [
                put({
                    type: types.DELETE_CHARGES_SUCCESS,
                    id: payload.payload.id
                }),
                put({ type: types.SET_LOADING, payload: false })
            ];
        }


    } catch (error) {
        yield [
            put({
                type: types.DELETE_CHARGES_SUCCESS,
                id: payload.payload.id
            }),
            put({ type: types.SET_LOADING, payload: false })
        ];
        yield put({ type: types.DELETE_CHARGES_ERROR, error });
    }
}


