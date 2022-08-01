import { call, put } from "redux-saga/effects";
import * as types from "../../../actions";
import {
    addloadTypesNaturesService, addMultiloadTypesNaturesService,
    deleteloadTypesNaturesService, getloadTypesNaturesService,
    updateloadTypesNaturesService
} from "../../../services/crud/load/natureServices";



export function* getloadTypesNaturesSaga(payload) {
    try {
        yield [
            put({ type: types.SET_LOADING, payload: true })
        ];
        let response = yield call(getloadTypesNaturesService, payload);
        if (response.data) {
            yield [
                put({ type: types.GET_LOAD_NATURES_SUCCESS, response }),
                put({ type: types.SET_LOADING, payload: false })
            ];
        }

    } catch (error) {
        yield [
            put({ type: types.GET_LOAD_NATURES_ERROR, error }),
            put({ type: types.SET_LOADING, payload: false })
        ];
    }
}


export function* addloadTypesNaturesSaga(payload) {
    try {
        yield [
            put({ type: types.SET_LOADING, payload: true })
        ];
        let response = yield call(addloadTypesNaturesService, payload);

        yield [
            put({ type: types.ADD_LOAD_NATURES_SUCCESS, response }),
            put({ type: types.SET_LOADING, payload: false })
        ];
    } catch (error) {
        yield [
            put({ type: types.ADD_LOAD_NATURES_ERROR, error }),
            put({ type: types.SET_LOADING, payload: false })
        ];
    }
}
export function* updateloadTypesNaturesSaga(payload) {
    try {
        yield [
            put({ type: types.SET_LOADING, payload: true })
        ];
        let response = yield call(updateloadTypesNaturesService, payload);
        if (response.error) {
            yield [
                put({ type: types.UPDATE_LOAD_NATURES_ERROR, response: response.error }),
                put({ type: types.SET_LOADING, payload: false })
            ];

        } else {
            yield [
                put({
                    type: types.UPDATE_LOAD_NATURES_SUCCESS,
                    response:
                        response, id: payload.payload.id
                }),
                put({ type: types.SET_LOADING, payload: false })
            ];
        }

    } catch (error) {
        yield [
            put({ type: types.UPDATE_LOAD_NATURES_ERROR, error }),
            put({ type: types.SET_LOADING, payload: false })
        ];
    }
}
export function* deleteloadTypesNaturesSaga(payload) {
    try {
        yield [
            put({ type: types.SET_LOADING, payload: true })
        ];
        let response = yield call(deleteloadTypesNaturesService, payload);
        if (response.error) {
            yield [
                put({ type: types.DELETE_LOAD_NATURES_ERROR, response: response.error }),
                put({ type: types.SET_LOADING, payload: false })
            ];

        } else {
            yield [
                put({
                    type: types.DELETE_LOAD_NATURES_SUCCESS,
                    id: payload.payload.id
                }),
                put({ type: types.SET_LOADING, payload: false })
            ];
        }


    } catch (error) {
        yield [
            put({
                type: types.DELETE_LOAD_NATURES_SUCCESS,
                id: payload.payload.id
            })
        ];
        yield put({ type: types.DELETE_LOAD_NATURES_ERROR, error });
    }
}


export function* addMultiloadTypesNaturesSaga(payload) {
    try {
        yield [
            put({ type: types.SET_LOADING, payload: true })
        ];
        let response = yield call(addMultiloadTypesNaturesService, payload);
        if (response.error) {
            yield [
                put({ type: types.ADD_MULTIPLE_LOAD_NATURES_ERROR, response: response.error }),
                put({ type: types.SET_LOADING, payload: false })
            ];

        } else {
            yield [
                put({ type: types.ADD_MULTIPLE_LOAD_NATURES_SUCCESS, response }),
                put({ type: types.SET_LOADING, payload: false })
            ];
        }

    } catch (error) {
        yield [
            put({ type: types.ADD_MULTIPLE_LOAD_NATURES_ERROR, error }),
            put({ type: types.SET_LOADING, payload: false })
        ];
    }
}
