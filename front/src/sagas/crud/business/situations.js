import { call, put } from "redux-saga/effects";
import * as types from "../../../actions";
import {
    addBusinessSituationsService, addMultiBusinessSituationsService, deleteBusinessSituationsService,
    getBusinessSituationsService, updateBusinessSituationsService
} from "../../../services/crud/business/situationServices";


export function* getBusinessSituationsSaga(payload) {
    try {
        yield [
            put({ type: types.SET_LOADING, payload: true })
        ];
        let response = yield call(getBusinessSituationsService, payload);

        yield [
            put({ type: types.GET_BUSINESS_SITUATIONS_SUCCESS, response }),
            put({ type: types.SET_LOADING, payload: false })
        ];
    } catch (error) {
        yield [
            put({ type: types.GET_BUSINESS_SITUATIONS_ERROR, error }),
            put({ type: types.SET_LOADING, payload: false })
        ];
    }
}
export function* addBusinessSituationsSaga(payload) {
    try {
        yield [
            put({ type: types.SET_LOADING, payload: true })
        ];
        let response = yield call(addBusinessSituationsService, payload);

        yield [
            put({ type: types.ADD_BUSINESS_SITUATIONS_SUCCESS, response }),
            put({ type: types.SET_LOADING, payload: false })
        ];
    } catch (error) {
        yield [
            put({ type: types.ADD_BUSINESS_SITUATIONS_ERROR, error }),
            put({ type: types.SET_LOADING, payload: false })
        ];
    }
}
export function* updateBusinessSituationsSaga(payload) {
    try {
        yield [
            put({ type: types.SET_LOADING, payload: true })
        ];
        let response = yield call(updateBusinessSituationsService, payload);
        if (response.error) {
            yield [
                put({ type: types.UPDATE_BUSINESS_SITUATIONS_ERROR, response: response.error }),
                put({ type: types.SET_LOADING, payload: false })
            ];

        } else {
            yield [
                put({
                    type: types.UPDATE_BUSINESS_SITUATIONS_SUCCESS,
                    response:
                        response, id: payload.payload.id
                }),
                put({ type: types.SET_LOADING, payload: false })
            ];
        }

    } catch (error) {
        yield [
            put({ type: types.UPDATE_BUSINESS_SITUATIONS_ERROR, error }),
            put({ type: types.SET_LOADING, payload: false })
        ];
    }
}
export function* deleteBusinessSituationsSaga(payload) {
    try {
        yield [
            put({ type: types.SET_LOADING, payload: true })
        ];
        let response = yield call(deleteBusinessSituationsService, payload);
        if (response.error) {
            yield [
                put({ type: types.DELETE_BUSINESS_SITUATIONS_ERROR, response: response.error }),
                put({ type: types.SET_LOADING, payload: false })
            ];

        } else {
            yield [
                put({
                    type: types.DELETE_BUSINESS_SITUATIONS_SUCCESS,
                    id: payload.payload.id
                }),
                put({ type: types.SET_LOADING, payload: false })
            ];
        }


    } catch (error) {
        yield [
            put({
                type: types.DELETE_BUSINESS_SITUATIONS_SUCCESS,
                id: payload.payload.id
            }),
            put({ type: types.SET_LOADING, payload: false })
        ];
        yield put({ type: types.DELETE_BUSINESS_SITUATIONS_ERROR, error });
    }
}


export function* addMultiBusinessSituationsSaga(payload) {
    try {
        yield [
            put({ type: types.SET_LOADING, payload: true })
        ];
        let response = yield call(addMultiBusinessSituationsService, payload);
        if (response.error) {
            yield [
                put({ type: types.ADD_MULTIPLE_BUSINESS_SITUATIONS_ERROR, response: response.error }),
                put({ type: types.SET_LOADING, payload: false })
            ];

        } else {
            yield [
                put({ type: types.ADD_MULTIPLE_BUSINESS_SITUATIONS_SUCCESS, response }),
                put({ type: types.SET_LOADING, payload: false })
            ];
        }

    } catch (error) {
        yield [
            put({ type: types.ADD_MULTIPLE_BUSINESS_SITUATIONS_ERROR, error }),
            put({ type: types.SET_LOADING, payload: false })
        ];
    }
}
