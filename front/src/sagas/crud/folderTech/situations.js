import { call, put } from "redux-saga/effects";
import * as types from "../../../actions";
import {
    addFolderTechSituationsService, addMultiFolderTechSituationsService, deleteFolderTechSituationsService,
    getFolderTechSituationsService, updateFolderTechSituationsService
} from "../../../services/crud/folderTech/situationServices";


export function* getFolderTechSituationsSaga(payload) {
    try {
        yield [
            put({ type: types.SET_LOADING, payload: true })
        ];
        let response = yield call(getFolderTechSituationsService, payload);

        yield [
            put({ type: types.GET_FOLDERTECH_SITUATIONS_SUCCESS, response }),
            put({ type: types.SET_LOADING, payload: false })
        ];
    } catch (error) {
        yield [
            put({ type: types.GET_FOLDERTECH_SITUATIONS_ERROR, error }),
            put({ type: types.SET_LOADING, payload: false })
        ];
    }
}
export function* addFolderTechSituationsSaga(payload) {
    try {
        yield [
            put({ type: types.SET_LOADING, payload: true })
        ];
        let response = yield call(addFolderTechSituationsService, payload);

        yield [
            put({ type: types.ADD_FOLDERTECH_SITUATIONS_SUCCESS, response }),
            put({ type: types.SET_LOADING, payload: false })
        ];
    } catch (error) {
        yield [
            put({ type: types.ADD_FOLDERTECH_SITUATIONS_ERROR, error }),
            put({ type: types.SET_LOADING, payload: false })
        ];
    }
}
export function* updateFolderTechSituationsSaga(payload) {
    try {
        yield [
            put({ type: types.SET_LOADING, payload: true })
        ];
        let response = yield call(updateFolderTechSituationsService, payload);
        if (response.error) {
            yield [
                put({ type: types.UPDATE_FOLDERTECH_SITUATIONS_ERROR, response: response.error }),
                put({ type: types.SET_LOADING, payload: false })
            ];

        } else {
            yield [
                put({
                    type: types.UPDATE_FOLDERTECH_SITUATIONS_SUCCESS,
                    response:
                        response, id: payload.payload.id
                }),
                put({ type: types.SET_LOADING, payload: false })
            ];
        }

    } catch (error) {
        yield [
            put({ type: types.UPDATE_FOLDERTECH_SITUATIONS_ERROR, error }),
            put({ type: types.SET_LOADING, payload: false })
        ];
    }
}
export function* deleteFolderTechSituationsSaga(payload) {
    try {
        yield [
            put({ type: types.SET_LOADING, payload: true })
        ];
        let response = yield call(deleteFolderTechSituationsService, payload);
        if (response.error) {
            yield [
                put({ type: types.DELETE_FOLDERTECH_SITUATIONS_ERROR, response: response.error }),
                put({ type: types.SET_LOADING, payload: false })
            ];

        } else {
            yield [
                put({
                    type: types.DELETE_FOLDERTECH_SITUATIONS_SUCCESS,
                    id: payload.payload.id
                }),
                put({ type: types.SET_LOADING, payload: false })
            ];
        }


    } catch (error) {
        yield [
            put({
                type: types.DELETE_FOLDERTECH_SITUATIONS_SUCCESS,
                id: payload.payload.id
            }),
            put({ type: types.SET_LOADING, payload: false })
        ];
        yield put({ type: types.DELETE_FOLDERTECH_SITUATIONS_ERROR, error });
    }
}


export function* addMultiFolderTechSituationsSaga(payload) {
    try {
        yield [
            put({ type: types.SET_LOADING, payload: true })
        ];
        let response = yield call(addMultiFolderTechSituationsService, payload);
        if (response.error) {
            yield [
                put({ type: types.ADD_MULTIPLE_FOLDERTECH_SITUATIONS_ERROR, response: response.error }),
                put({ type: types.SET_LOADING, payload: false })
            ];

        } else {
            yield [
                put({ type: types.ADD_MULTIPLE_FOLDERTECH_SITUATIONS_SUCCESS, response }),
                put({ type: types.SET_LOADING, payload: false })
            ];
        }

    } catch (error) {
        yield [
            put({ type: types.ADD_MULTIPLE_FOLDERTECH_SITUATIONS_ERROR, error }),
            put({ type: types.SET_LOADING, payload: false })
        ];
    }
}
