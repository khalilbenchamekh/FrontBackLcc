import { call, put } from "redux-saga/effects";
import * as types from "../../../actions";
import {
    addBusinessNaturesService,
    addMultiBusinessNaturesService, deleteBusinessNaturesService, getBusinessNaturesService,
    updateBusinessNaturesService
} from "../../../services/crud/business/natureServices";

export function* getBusinessNaturesSaga(payload) {
    try {

        yield [
            put({ type: types.SET_LOADING, payload: true })
        ];
        let response = yield call(getBusinessNaturesService, payload);

        yield [
            put({ type: types.GET_BUSINESS_NATURES_SUCCESS, response }),
            put({ type: types.SET_LOADING, payload: false })
        ];
    } catch (error) {
        yield [
            put({ type: types.GET_BUSINESS_NATURES_ERROR, error }),
            put({ type: types.SET_LOADING, payload: false })
        ];
    }
}
export function* addBusinessNaturesSaga(payload) {
    try {
        yield [
            put({ type: types.SET_LOADING, payload: true })
        ];
        let response = yield call(addBusinessNaturesService, payload);

        yield [
            put({ type: types.ADD_BUSINESS_NATURES_SUCCESS, response }),
            put({ type: types.SET_LOADING, payload: false })
        ];
    } catch (error) {
        yield [
            put({ type: types.ADD_BUSINESS_NATURES_ERROR, error }),
            put({ type: types.SET_LOADING, payload: false })
        ];
    }
}
export function* updateBusinessNaturesSaga(payload) {
    try {
        yield [
            put({ type: types.SET_LOADING, payload: true })
        ];
        let response = yield call(updateBusinessNaturesService, payload);
        if (response.error) {
            yield [
                put({ type: types.UPDATE_BUSINESS_NATURES_ERROR, response: response.error }),
                put({ type: types.SET_LOADING, payload: false })
            ];

        } else {
            yield [
                put({
                    type: types.UPDATE_BUSINESS_NATURES_SUCCESS,
                    response:
                        response, id: payload.payload.id
                }),
                put({ type: types.SET_LOADING, payload: false })
            ];
        }

    } catch (error) {
        yield [
            put({ type: types.UPDATE_BUSINESS_NATURES_ERROR, error }),
            put({ type: types.SET_LOADING, payload: false })
        ];
    }
}
export function* deleteBusinessNaturesSaga(payload) {
    try {
        yield [
            put({ type: types.SET_LOADING, payload: true })
        ];
        let response = yield call(deleteBusinessNaturesService, payload);
        if (response.error) {
            yield [
                put({ type: types.DELETE_BUSINESS_NATURES_ERROR, response: response.error }),
                put({ type: types.SET_LOADING, payload: false })
            ];

        } else {
            yield [
                put({
                    type: types.DELETE_BUSINESS_NATURES_SUCCESS,
                    id: payload.payload.id
                }),
                put({ type: types.SET_LOADING, payload: false })
            ];
        }


    } catch (error) {
        yield [
            put({
                type: types.DELETE_BUSINESS_NATURES_SUCCESS,
                id: payload.payload.id
            }),
            put({ type: types.SET_LOADING, payload: false })
        ];
        yield put({ type: types.DELETE_BUSINESS_NATURES_ERROR, error });
    }
}


export function* addMultiBusinessNaturesSaga(payload) {
    try {
        yield [
            put({ type: types.SET_LOADING, payload: true })
        ];
        let response = yield call(addMultiBusinessNaturesService, payload);
        if (response.error) {
            yield [
                put({ type: types.ADD_MULTIPLE_BUSINESS_NATURES_ERROR, response: response.error }),
                put({ type: types.SET_LOADING, payload: false })
            ];

        } else {
            yield [
                put({ type: types.ADD_MULTIPLE_BUSINESS_NATURES_SUCCESS, response }),
                put({ type: types.SET_LOADING, payload: false })
            ];
        }

    } catch (error) {
        yield [
            put({ type: types.ADD_MULTIPLE_BUSINESS_NATURES_ERROR, error }),
            put({ type: types.SET_LOADING, payload: false })
        ];
    }
}
