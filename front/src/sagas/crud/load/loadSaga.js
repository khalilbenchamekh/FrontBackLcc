import { call, put } from "redux-saga/effects";
import * as types from "../../../actions";
import {
    addLoadsService, deleteLoadsService,
    getLoadsService,
    getSatitstiquesLoadService,
    updateLoadsService
} from "../../../services/crud/load/loadService";


export function* getLoadsSaga(payload) {
    try {
        yield [
            put({ type: types.SET_LOADING, payload: true })
        ];
        let response = yield call(getLoadsService, payload);

        yield [
            put({ type: types.GET_LOAD_SUCCESS, response }),
            put({ type: types.SET_LOADING, payload: false })
        ];
    } catch (error) {
        yield [
            put({ type: types.GET_LOAD_ERROR, error }),
            put({ type: types.SET_LOADING, payload: false })
        ];
    }
}
export function* addLoadsSaga(payload) {
    try {
        yield [
            put({ type: types.SET_LOADING, payload: true })
        ];
        let response = yield call(addLoadsService, payload);

        yield [
            put({ type: types.ADD_LOAD_SUCCESS, response }),
            put({ type: types.SET_LOADING, payload: false })
        ];
    } catch (error) {
        yield [
            put({ type: types.ADD_LOAD_ERROR, error }),
            put({ type: types.SET_LOADING, payload: false })
        ];
    }
}
export function* updateLoadsSaga(payload) {
    try {
        yield [
            put({ type: types.SET_LOADING, payload: true })
        ];
        let response = yield call(updateLoadsService, payload);
        if (response.error) {
            yield [
                put({ type: types.UPDATE_LOAD_ERROR, response: response.error }),
                put({ type: types.SET_LOADING, payload: false })
            ];

        } else {
            yield [
                put({
                    type: types.UPDATE_LOAD_SUCCESS,
                    response:
                        response, id: payload.payload.index
                }),
                put({ type: types.SET_LOADING, payload: false })
            ];
        }

    } catch (error) {
        yield [
            put({ type: types.UPDATE_LOAD_ERROR, error }),
            put({ type: types.SET_LOADING, payload: false })
        ];
    }
}
export function* getSatitstiquesLoadSaga(payload) {
    try {
        yield [
            put({ type: types.SET_LOADING, payload: true })
        ];
        let response = yield call(getSatitstiquesLoadService, payload);
        if (response.error) {
            yield [
                put({ type: types.GET_STATISTIQUES_LOAD_ERROR, response: response.error }),
                put({ type: types.SET_LOADING, payload: false })
            ];

        } else {
            yield [
                put({
                    type: types.GET_STATISTIQUES_LOAD_SUCCESS,
                    response:
                        response, id: payload.payload.id
                }),
                put({ type: types.SET_LOADING, payload: false })
            ];
        }

    } catch (error) {
        yield [
            put({ type: types.GET_STATISTIQUES_LOAD_ERROR, error }),
            put({ type: types.SET_LOADING, payload: false })
        ];
    }
}

export function* deleteLoadsSaga(payload) {
    try {
        yield [
            put({ type: types.SET_LOADING, payload: true })
        ];
        let response = yield call(deleteLoadsService, payload);
        if (response.error) {
            yield [
                put({ type: types.DELETE_LOAD_ERROR, response: response.error }),
                put({ type: types.SET_LOADING, payload: false })
            ];

        } else {
            yield [
                put({
                    type: types.DELETE_LOAD_SUCCESS,
                    id: payload.payload.id
                }),
                put({ type: types.SET_LOADING, payload: false })
            ];
        }


    } catch (error) {
        yield [
            put({
                type: types.DELETE_LOAD_SUCCESS,
                id: payload.payload.id
            }),
            put({ type: types.SET_LOADING, payload: false })
        ];
        yield put({ type: types.DELETE_LOAD_ERROR, error });
    }
}


