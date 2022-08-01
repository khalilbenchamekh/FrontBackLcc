import { call, put } from "redux-saga/effects";
import * as types from "../../../actions";
import {
    addFolderTechNaturesService,
    addMultiFolderTechNaturesService, deleteFolderTechNaturesService,
    getFolderTechNaturesService, updateFolderTechNaturesService
} from "../../../services/crud/folderTech/natureServices";

export function* getFolderTechNaturesSaga(payload) {
    try {

        yield [
            put({ type: types.SET_LOADING, payload: true })
        ];
        let response = yield call(getFolderTechNaturesService, payload);

        yield [
            put({ type: types.GET_FOLDERTECH_NATURES_SUCCESS, response }),
            put({ type: types.SET_LOADING, payload: false })
        ];
    } catch (error) {
        yield [
            put({ type: types.GET_FOLDERTECH_NATURES_ERROR, error }),
            put({ type: types.SET_LOADING, payload: false })
        ];
    }
}
export function* addFolderTechNaturesSaga(payload) {
    try {
        yield [
            put({ type: types.SET_LOADING, payload: true })
        ];
        let response = yield call(addFolderTechNaturesService, payload);

        yield [
            put({ type: types.ADD_FOLDERTECH_NATURES_SUCCESS, response }),
            put({ type: types.SET_LOADING, payload: false })
        ];
    } catch (error) {
        yield [
            put({ type: types.ADD_FOLDERTECH_NATURES_ERROR, error }),
            put({ type: types.SET_LOADING, payload: false })
        ];
    }
}
export function* updateFolderTechNaturesSaga(payload) {
    try {
        yield [
            put({ type: types.SET_LOADING, payload: true })
        ];
        let response = yield call(updateFolderTechNaturesService, payload);
        if (response.error) {
            yield put({ type: types.UPDATE_FOLDERTECH_NATURES_ERROR, response: response.error });

        } else {
            yield [
                put({
                    type: types.UPDATE_FOLDERTECH_NATURES_SUCCESS,
                    response:
                        response, id: payload.payload.id
                }),
                put({ type: types.SET_LOADING, payload: false })
            ];
        }

    } catch (error) {
        yield [
            put({ type: types.UPDATE_FOLDERTECH_NATURES_ERROR, error }),
            put({ type: types.SET_LOADING, payload: false })
        ];
    }
}
export function* deleteFolderTechNaturesSaga(payload) {
    try {
        yield [
            put({ type: types.SET_LOADING, payload: true })
        ];
        let response = yield call(deleteFolderTechNaturesService, payload);
        if (response.error) {
            yield put({ type: types.DELETE_FOLDERTECH_NATURES_ERROR, response: response.error });

        } else {
            yield [
                put({
                    type: types.DELETE_FOLDERTECH_NATURES_SUCCESS,
                    id: payload.payload.id
                }),
                put({ type: types.SET_LOADING, payload: false })
            ];
        }


    } catch (error) {
        yield [
            put({
                type: types.DELETE_FOLDERTECH_NATURES_SUCCESS,
                id: payload.payload.id
            }),
            put({ type: types.SET_LOADING, payload: false })
        ];
        yield put({ type: types.DELETE_FOLDERTECH_NATURES_ERROR, error });
    }
}


export function* addMultiFolderTechNaturesSaga(payload) {
    try {
        yield [
            put({ type: types.SET_LOADING, payload: true })
        ];
        let response = yield call(addMultiFolderTechNaturesService, payload);
        if (response.error) {
            yield [
                put({ type: types.ADD_MULTIPLE_FOLDERTECH_NATURES_ERROR, response: response.error }),
                put({ type: types.SET_LOADING, payload: false })
            ];

        } else {
            yield [
                put({ type: types.ADD_MULTIPLE_FOLDERTECH_NATURES_SUCCESS, response }),
                put({ type: types.SET_LOADING, payload: false })
            ];
        }

    } catch (error) {
        yield [
            put({ type: types.ADD_MULTIPLE_FOLDERTECH_NATURES_ERROR, error }),
            put({ type: types.SET_LOADING, payload: false })
        ];
    }
}
