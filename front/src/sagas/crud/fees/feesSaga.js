import { call, put } from "redux-saga/effects";
import * as types from "../../../actions";

import {
    getBusinessByIdService,
    getBusinessFeesService, getFolderTechByIdService,
    getFolderTechFeesService,
    saveBusinessFeesService,
    saveFolderTechFeesService,
    updateBusinessFeesService,
    updateFolderTechFeesService
} from "../../../services/crud/fess/fessService";


export function* getFolderTechByIdSaga(payload) {
    try {

        yield [
            put({ type: types.SET_LOADING, payload: true })
        ];
        let response = yield call(getFolderTechByIdService, payload);

        yield [
            put({ type: types.GET_FOLDER_TECH_BY_ID_SUCCESS, response }),
            put({ type: types.SET_LOADING, payload: false })
        ];
    } catch (error) {
        yield [
            put({ type: types.GET_FOLDER_TECH_BY_ID_ERROR, error }),
            put({ type: types.SET_LOADING, payload: false })
        ];
    }
}

export function* getBusinessByIdSaga(payload) {
    try {
        yield [
            put({ type: types.SET_LOADING, payload: true })
        ];
        let response = yield call(getBusinessByIdService, payload);

        yield [
            put({ type: types.GET_BUSINESS_BY_ID_SUCCESS, response }),
            put({ type: types.SET_LOADING, payload: false })
        ];
    } catch (error) {
        yield [
            put({ type: types.GET_BUSINESS_BY_ID_ERROR, error }),
            put({ type: types.SET_LOADING, payload: false })
        ];
    }
}

export function* getBusinessFeesSaga(payload) {
    try {
        yield [
            put({ type: types.SET_LOADING, payload: true })
        ];
        let response = yield call(getBusinessFeesService, payload);

        yield [
            put({ type: types.GET_BUSINESS_FEES_SUCCESS, response }),
            put({ type: types.SET_LOADING, payload: false })
        ];
    } catch (error) {
        yield [
            put({ type: types.GET_BUSINESS_FEES_ERROR, error }),
            put({ type: types.SET_LOADING, payload: false })
        ];
    }
}

export function* getFolderTechFeesSaga(payload) {
    try {
        yield [
            put({ type: types.SET_LOADING, payload: true })
        ];

        let response = yield call(getFolderTechFeesService, payload);

        yield [
            put({ type: types.GET_FOLDER_TECH_FEES_SUCCESS, response }),
            put({ type: types.SET_LOADING, payload: false })
        ];
    } catch (error) {
        yield [
            put({ type: types.GET_FOLDER_TECH_FEES_ERROR, error }),
            put({ type: types.SET_LOADING, payload: false })
        ];
    }
}

export function* saveBusinessFeesSaga(payload) {
    try {
        yield [
            put({ type: types.SET_LOADING, payload: true })
        ];
        let response = yield call(saveBusinessFeesService, payload);

        yield [
            put({ type: types.ADD_BUSINESS_FEES_SUCCESS, response }),
            put({ type: types.SET_LOADING, payload: false })
        ];
    } catch (error) {
        yield [
            put({ type: types.ADD_BUSINESS_FEES_ERROR, error }),
            put({ type: types.SET_LOADING, payload: false })
        ];
    }
}

export function* saveFolderTechFeesSaga(payload) {
    try {
        yield [
            put({ type: types.SET_LOADING, payload: true })
        ];
        let response = yield call(saveFolderTechFeesService, payload);

        yield [
            put({ type: types.ADD_FOLDER_TECH_FEES_SUCCESS, response }),
            put({ type: types.SET_LOADING, payload: false })
        ];
    } catch (error) {
        yield [
            put({ type: types.ADD_FOLDER_TECH_FEES_ERROR, error }),
            put({ type: types.SET_LOADING, payload: false })
        ];
    }
}

export function* updateBusinessFeesSaga(payload) {
    try {
        yield [
            put({ type: types.SET_LOADING, payload: true })
        ];
        let response = yield call(updateBusinessFeesService, payload);
        if (response.error) {
            yield [
                put({ type: types.UPDATE_BUSINESS_FEES_ERROR, response: response.error }),
                put({ type: types.SET_LOADING, payload: false })
            ];

        } else {
            yield [
                put({
                    type: types.UPDATE_BUSINESS_FEES_SUCCESS,
                    response:
                        response, id: payload.payload.index
                }),
                put({ type: types.SET_LOADING, payload: false })
            ];
        }

    } catch (error) {
        yield [
            put({ type: types.UPDATE_BUSINESS_FEES_ERROR, error }),
            put({ type: types.SET_LOADING, payload: false })
        ];
    }
}

export function* updateFolderTechFeesSaga(payload) {
    try {
        yield [
            put({ type: types.SET_LOADING, payload: true })
        ];
        let response = yield call(updateFolderTechFeesService, payload);
        if (response.error) {
            yield [
                put({ type: types.UPDATE_FOLDER_TECH_FEES_ERROR, response: response.error }),
                put({ type: types.SET_LOADING, payload: false })
            ];

        } else {
            yield [
                put({
                    type: types.UPDATE_FOLDER_TECH_FEES_SUCCESS,
                    response:
                        response, id: payload.payload.index
                }),
                put({ type: types.SET_LOADING, payload: false })
            ];
        }

    } catch (error) {
        yield [
            put({ type: types.UPDATE_FOLDER_TECH_FEES_ERROR, error }),
            put({ type: types.SET_LOADING, payload: false })
        ];
    }
}





