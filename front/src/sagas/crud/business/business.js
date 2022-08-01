import { call, put } from "redux-saga/effects";
import * as types from "../../../actions";
import {
    addBusinessService, addMultiBusinessService,
    deleteBusinessService,
    getBusinessService,
    updateBusinessService
} from "../../../services/crud/business/business";


export function* getBusinessSaga(payload) {
    try {
        yield [
            put({ type: types.SET_LOADING, payload: true })
        ];

        let response = yield call(getBusinessService, payload);

        yield [
            put({ type: types.GET_BUSINESS_SUCCESS, response }),
            put({ type: types.SET_LOADING, payload: false })
        ];
    } catch (error) {
        yield [
            put({ type: types.GET_BUSINESS_ERROR, error }),
            put({ type: types.SET_LOADING, payload: false })
        ];
    }
}
export function* addBusinessSaga(payload) {
    try {

        yield [
            put({ type: types.SET_LOADING, payload: true })
        ];

        let response = yield call(addBusinessService, payload);

        yield [
            put({ type: types.ADD_BUSINESS_SUCCESS, response }),
            put({ type: types.SET_LOADING, payload: false })
        ];
    } catch (error) {
        yield [
            put({ type: types.ADD_BUSINESS_ERROR, error }),
            put({ type: types.SET_LOADING, payload: false })
        ];
    }
}
export function* updateBusinessSaga(payload) {
    try {

        yield [
            put({ type: types.SET_LOADING, payload: true })
        ];

        let response = yield call(updateBusinessService, payload);
        if (response.error) {
            yield [
                put({ type: types.UPDATE_BUSINESS_ERROR, response: response.error }),
                put({ type: types.SET_LOADING, payload: false })
            ];

        } else {
            yield [
                put({
                    type: types.UPDATE_BUSINESS_SUCCESS,
                    response:
                        response, id: payload.payload.id
                }),
                put({ type: types.SET_LOADING, payload: false })
            ];
        }

    } catch (error) {
        yield [
            put({ type: types.UPDATE_BUSINESS_ERROR, error }),
            put({ type: types.SET_LOADING, payload: false })
        ];
    }
}
export function* deleteBusinessSaga(payload) {
    try {
        yield [
            put({ type: types.SET_LOADING, payload: true })
        ];
        let response = yield call(deleteBusinessService, payload);
        if (response.error) {
            yield [
                put({ type: types.DELETE_BUSINESS_ERROR, response: response.error }),
                put({ type: types.SET_LOADING, payload: false })
            ];

        } else {
            yield [
                put({
                    type: types.DELETE_BUSINESS_SUCCESS,
                    id: payload.payload.id
                }),
                put({ type: types.SET_LOADING, payload: false })
            ];
        }


    } catch (error) {
        yield [
            put({
                type: types.DELETE_BUSINESS_SUCCESS,
                id: payload.payload.id
            })
        ];
        yield put({ type: types.DELETE_BUSINESS_ERROR, error });
    }
}

export function* addMultiBusinessSaga(payload) {
    try {
        yield [
            put({ type: types.SET_LOADING, payload: true })
        ];
        let response = yield call(addMultiBusinessService, payload);
        if (response.error) {
            yield [
                put({ type: types.ADD_MULTIPLE_BUSINESS_ERROR, response: response.error }),
                put({ type: types.SET_LOADING, payload: false })
            ];

        } else {
            yield [
                put({ type: types.ADD_MULTIPLE_BUSINESS_SUCCESS, response }),
                put({ type: types.SET_LOADING, payload: false })
            ];
        }

    } catch (error) {
        yield [
            put({ type: types.ADD_MULTIPLE_BUSINESS_ERROR, error }),
            put({ type: types.SET_LOADING, payload: false })
        ];
    }
}
