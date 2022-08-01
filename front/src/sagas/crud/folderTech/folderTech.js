import { call, put } from "redux-saga/effects";
import * as types from "../../../actions";
import {
    addFolderTechService, deleteFolderTechService,
    getFolderTechService,
    updateFolderTechService
} from "../../../services/crud/folderTech/folderTech";



export function* getFolderTechSaga(payload) {
    try {
        yield [
            put({ type: types.SET_LOADING, payload: true })
        ];
        let response = yield call(getFolderTechService, payload);

        yield [
            put({ type: types.GET_FOLDERTECH_SUCCESS, response }),
            put({ type: types.SET_LOADING, payload: false })
        ];
    } catch (error) {
        yield [
            put({ type: types.GET_FOLDERTECH_ERROR, error }),
            put({ type: types.SET_LOADING, payload: false })
        ];
    }
}
export function* addFolderTechSaga(payload) {
    try {
        yield [
            put({ type: types.SET_LOADING, payload: true })
        ];
        let response = yield call(addFolderTechService, payload);

        yield [
            put({ type: types.ADD_FOLDERTECH_SUCCESS, response }),
            put({ type: types.SET_LOADING, payload: false })
        ];
    } catch (error) {
        yield [
            put({ type: types.ADD_FOLDERTECH_ERROR, error }),
            put({ type: types.SET_LOADING, payload: false })
        ];
    }
}
export function* updateFolderTechSaga(payload) {
    try {
        yield [
            put({ type: types.SET_LOADING, payload: true })
        ];
        let response = yield call(updateFolderTechService, payload);
        if (response.error) {
            yield [
                put({ type: types.UPDATE_FOLDERTECH_ERROR, response: response.error }),
                put({ type: types.SET_LOADING, payload: false })
            ];

        } else {
            yield [
                put({
                    type: types.UUPDATE_FOLDERTECH_SUCCESS,
                    response:
                        response, id: payload.payload.id
                }),
                put({ type: types.SET_LOADING, payload: false })
            ];
        }

    } catch (error) {
        yield [
            put({ type: types.UPDATE_FOLDERTECH_ERROR, error }),
            put({ type: types.SET_LOADING, payload: false })
        ];
    }
}
export function* deleteFolderTechSaga(payload) {
    try {
        yield [
            put({ type: types.SET_LOADING, payload: true })
        ];
        let response = yield call(deleteFolderTechService, payload);
        if (response.error) {
            yield [
                put({ type: types.DELETE_FOLDERTECH_ERROR, response: response.error }),
                put({ type: types.SET_LOADING, payload: false })
            ];

        } else {
            yield [
                put({
                    type: types.DELETE_FOLDERTECH_SUCCESS,
                    id: payload.payload.id
                }),
                put({ type: types.SET_LOADING, payload: false })
            ];
        }


    } catch (error) {
        yield [
            put({
                type: types.DELETE_FOLDERTECH_SUCCESS,
                id: payload.payload.id
            }),
            put({ type: types.SET_LOADING, payload: false })
        ];
        yield put({ type: types.DELETE_FOLDERTECH_ERROR, error });
    }
}

