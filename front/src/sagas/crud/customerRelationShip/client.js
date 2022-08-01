import { call, put } from "redux-saga/effects";
import * as types from "../../../actions";
import {
    addClientService, addClientsForSelectService, addMultiClientService, deleteClientService,
    getClientsService,
    updateClientService
} from "../../../services/crud/customerRelationShip/clientServices";


export function* getClientSaga(payload) {
    try {
        yield [
            put({ type: types.SET_LOADING, payload: true })
        ];
        let response = yield call(getClientsService, payload);

        yield [
            put({ type: types.GET_CLIENTS_SUCCESS, response }),
            put({ type: types.SET_LOADING, payload: false })
        ];
    } catch (error) {
        yield [
            put({ type: types.GET_CLIENTS_ERROR, error }),
            put({ type: types.SET_LOADING, payload: false })
        ];
    }
}

export function* addClientsForSelectSaga(payload) {
    try {
        yield [
            put({ type: types.SET_LOADING, payload: true })
        ];

        let response = yield call(addClientsForSelectService, payload);

        yield [
            put({ type: types.GET_CLIENT_FOR_SELECT_SUCCESS, response }),
            put({ type: types.SET_LOADING, payload: false })
        ];
    } catch (error) {
        yield [
            put({ type: types.GET_CLIENT_FOR_SELECT_ERROR, error }),
            put({ type: types.SET_LOADING, payload: false })
        ];
    }
}

export function* addClientSaga(payload) {
    try {
        yield [
            put({ type: types.SET_LOADING, payload: true })
        ];

        let response = yield call(addClientService, payload);
        if (response.error) {
            yield [
                put({ type: types.ADD_CLIENT_ERROR, response: response.error }),
                put({ type: types.SET_LOADING, payload: false })
            ];

        } else {
            yield [
                put({
                    type: types.ADD_CLIENT_SUCCESS,

                    response
                }),
                put({ type: types.SET_LOADING, payload: false })
            ];
        }

    } catch (error) {
        yield [
            put({ type: types.ADD_CLIENT_ERROR, error }),
            put({ type: types.SET_LOADING, payload: false })
        ];
    }
}

export function* updateClientSaga(payload) {
    try {

        yield [
            put({ type: types.SET_LOADING, payload: true })
        ];
        let response = yield call(updateClientService, payload);
        if (response.error) {
            yield [
                put({ type: types.UPDATE_CLIENT_ERROR, response: response.error }),
                put({ type: types.SET_LOADING, payload: false })
            ];

        } else {
            yield [
                put({
                    type: types.UPDATE_CLIENT_SUCCESS,
                    response:
                        response, id: payload.payload.id
                }),
                put({ type: types.SET_LOADING, payload: false })
            ];
        }

    } catch (error) {
        yield [
            put({ type: types.UPDATE_CLIENT_ERROR, error }),
            put({ type: types.SET_LOADING, payload: false })
        ];
    }
}

export function* deleteClientSaga(payload) {
    try {
        yield [
            put({ type: types.SET_LOADING, payload: true })
        ];
        let response = yield call(deleteClientService, payload);
        if (response.error) {
            yield [
                put({ type: types.DELETE_CLIENT_ERROR, response: response.error }),
                put({ type: types.SET_LOADING, payload: false })
            ];

        } else {
            yield [
                put({
                    type: types.DELETE_CLIENT_SUCCESS,
                    id: payload.payload.id
                }),
                put({ type: types.SET_LOADING, payload: false })
            ];
        }


    } catch (error) {
        yield [
            put({
                type: types.DELETE_CLIENT_SUCCESS,
                id: payload.payload.id
            }),
            put({ type: types.SET_LOADING, payload: false })
        ];
        yield put({ type: types.DELETE_CLIENT_ERROR, error });
    }
}

export function* addMultiClientSaga(payload) {
    try {
        let response = yield call(addMultiClientService, payload);
        if (response.error) {
            yield [
                put({ type: types.ADD_MULTIPLE_CLIENT_ERROR, response: response.error }),
                put({ type: types.SET_LOADING, payload: false })
            ];

        } else {
            yield [
                put({ type: types.ADD_MULTIPLE_CLIENT_SUCCESS, response }),
                put({ type: types.SET_LOADING, payload: false })
            ];
        }
    } catch (error) {
        yield [
            put({ type: types.ADD_MULTIPLE_CLIENT_ERROR, error }),
            put({ type: types.SET_LOADING, payload: false })
        ];
    }
}
