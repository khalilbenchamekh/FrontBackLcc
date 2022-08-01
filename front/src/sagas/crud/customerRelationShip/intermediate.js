import { call, put } from "redux-saga/effects";
import * as types from "../../../actions";
import {
    addIntermediatesService, addMultiIntermediatesService, deleteIntermediatesService,
    getIntermediatesService, updateIntermediatesService
} from "../../../services/crud/customerRelationShip/intermediateServices";



export function* getIntermediatesSaga(payload) {
    try {
        yield [
            put({ type: types.SET_LOADING, payload: true })
        ];
        let response = yield call(getIntermediatesService, payload);

        yield [
            put({ type: types.GET_INTERMEDIATES_SUCCESS, response }),
            put({ type: types.SET_LOADING, payload: false })
        ];
    } catch (error) {
        yield [
            put({ type: types.GET_INTERMEDIATE_ERROR, error }),
            put({ type: types.SET_LOADING, payload: false })
        ];
    }
}
export function* addIntermediatesSaga(payload) {
    try {
        yield [
            put({ type: types.SET_LOADING, payload: true })
        ];
        let response = yield call(addIntermediatesService, payload);
        if (response.error) {
            yield [
                put({ type: types.ADD_INTERMEDIATE_ERROR, response: response.error }),
                put({ type: types.SET_LOADING, payload: false })
            ];

        } else {
            yield [
                put({
                    type: types.ADD_INTERMEDIATE_SUCCESS,
                    response
                }),
                put({ type: types.SET_LOADING, payload: false })
            ];
        }

    } catch (error) {
        yield [
            put({ type: types.ADD_INTERMEDIATE_ERROR, error }),
            put({ type: types.SET_LOADING, payload: false })
        ];
    }
}
export function* updateIntermediatesSaga(payload) {
    try {
        yield [
            put({ type: types.SET_LOADING, payload: true })
        ];
        let response = yield call(updateIntermediatesService, payload);
        if (response.error) {
            yield [
                put({ type: types.UPDATE_INTERMEDIATE_ERROR, response: response.error }),
                put({ type: types.SET_LOADING, payload: false })
            ];

        } else {
            yield [
                put({
                    type: types.UPDATE_INTERMEDIATE_SUCCESS,
                    response:
                        response, id: payload.payload.id
                }),
                put({ type: types.SET_LOADING, payload: false })
            ];
        }

    } catch (error) {
        yield [
            put({ type: types.UPDATE_INTERMEDIATE_ERROR, error }),
            put({ type: types.SET_LOADING, payload: false })
        ];
    }
}
export function* deleteIntermediatesSaga(payload) {
    try {

        yield [
            put({ type: types.SET_LOADING, payload: true })
        ];
        let response = yield call(deleteIntermediatesService, payload);
        if (response.error) {
            yield [
                put({ type: types.DELETE_INTERMEDIATE_ERROR, response: response.error }),
                put({ type: types.SET_LOADING, payload: false })
            ];

        } else {
            yield [
                put({
                    type: types.DELETE_INTERMEDIATE_SUCCESS,
                    id: payload.payload.id
                }),
                put({ type: types.SET_LOADING, payload: false })
            ];
        }


    } catch (error) {
        yield [
            put({
                type: types.DELETE_INTERMEDIATE_SUCCESS,
                id: payload.payload.id
            }),
            put({ type: types.SET_LOADING, payload: false })
        ];
        yield put({ type: types.DELETE_INTERMEDIATE_ERROR, error });
    }
}


export function* addMultiIntermediatesSaga(payload) {
    try {

        yield [
            put({ type: types.SET_LOADING, payload: true })
        ];
        let response = yield call(addMultiIntermediatesService, payload);
        if (response.error) {
            yield [
                put({ type: types.ADD_MULTIPLE_INTERMEDIATE_ERROR, response: response.error }),
                put({ type: types.SET_LOADING, payload: false })
            ];

        } else {
            yield [
                put({ type: types.ADD_MULTIPLE_INTERMEDIATE_SUCCESS, response }),
                put({ type: types.SET_LOADING, payload: false })
            ];
        }

    } catch (error) {
        yield [
            put({ type: types.ADD_MULTIPLE_INTERMEDIATE_ERROR, error }),
            put({ type: types.SET_LOADING, payload: false })
        ];
    }
}
