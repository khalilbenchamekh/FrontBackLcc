import { call, put } from "redux-saga/effects";
import * as types from "../../../actions";
import {
    addgreatConstructionSitesService, deletegreatConstructionSitesService, getDatailsGreatConstructionSiteService,
    getgreatConstructionSitesService, getSatitstiquesGreatConstructionSiteService, updategreatConstructionSitesService
} from "../../../services/crud/greatConstructionSites/greatConstructionSitesService";

export function* getgreatConstructionSitesSaga(payload) {
    try {
        yield [
            put({ type: types.SET_LOADING, payload: true })
        ];
        let response = yield call(getgreatConstructionSitesService, payload);

        yield [
            put({ type: types.GET_GREAT_CONSULTATION_SITE_SUCCESS, response }),
            put({ type: types.SET_LOADING, payload: false })
        ];
    } catch (error) {
        yield [
            put({ type: types.GET_GREAT_CONSULTATION_SITE_ERROR, error }),
            put({ type: types.SET_LOADING, payload: false })
        ];
    }
}
export function* addgreatConstructionSitesSaga(payload) {
    try {
        yield [
            put({ type: types.SET_LOADING, payload: true })
        ];
        let response = yield call(addgreatConstructionSitesService, payload);
        if (response.data) {
            if (!response.data.name) {
                response = payload.payload.responseToReplace;
            }
            yield [
                put({ type: types.ADD_GREAT_CONSULTATION_SITE_SUCCESS, response }),
                put({ type: types.SET_LOADING, payload: false })
            ];
        } else {
            yield [
                put({ type: types.ADD_GREAT_CONSULTATION_SITE_ERROR, response }),
                put({ type: types.SET_LOADING, payload: false })
            ];
        }

    } catch (error) {
        yield put({ type: types.ADD_GREAT_CONSULTATION_SITE_ERROR, error });
    }
}
export function* updategreatConstructionSitesSaga(payload) {
    try {
        yield [
            put({ type: types.SET_LOADING, payload: true })
        ];
        let response = yield call(updategreatConstructionSitesService, payload);
        if (response.error) {
            yield [
                put({ type: types.UPDATE_GREAT_CONSULTATION_SITE_ERROR, response: response.error }),
                put({ type: types.SET_LOADING, payload: false })
            ];

        } else {
            yield [
                put({
                    type: types.UPDATE_GREAT_CONSULTATION_SITE_SUCCESS,
                    response:
                        response, id: payload.payload.id
                }),
                put({ type: types.SET_LOADING, payload: false })
            ];
        }

    } catch (error) {
        yield [
            put({ type: types.UPDATE_GREAT_CONSULTATION_SITE_ERROR, error }),
            put({ type: types.SET_LOADING, payload: false })
        ];
    }
}
export function* getSatitstiquesGreatConstructionSiteSaga(payload) {
    try {
        yield [
            put({ type: types.SET_LOADING, payload: true })
        ];
        let response = yield call(getSatitstiquesGreatConstructionSiteService, payload);
        if (response.error) {
            yield [
                put({ type: types.GET_STATISTIQUES_GREAT_CONSULTATION_SITE_ERROR, response: response.error }),
                put({ type: types.SET_LOADING, payload: false })
            ];

        } else {
            yield [
                put({
                    type: types.GET_STATISTIQUES_GREAT_CONSULTATION_SITE_SUCCESS,
                    response:
                        response, id: payload.payload.id
                }),
                put({ type: types.SET_LOADING, payload: false })
            ];
        }

    } catch (error) {
        yield [
            put({ type: types.GET_STATISTIQUES_GREAT_CONSULTATION_SITE_ERROR, error }),
            put({ type: types.SET_LOADING, payload: false })
        ];
    }
}
export function* getDatailsGreatConstructionSiteSaga(payload) {
    try {
        yield [
            put({ type: types.SET_LOADING, payload: true })
        ];
        let response = yield call(getDatailsGreatConstructionSiteService, payload);
        if (response.error) {
            yield [
                put({ type: types.DETAILS_GREAT_CONSULTATION_SITE_ERROR, response: response.error }),
                put({ type: types.SET_LOADING, payload: false })
            ];

        } else {
            yield [
                put({
                    type: types.DETAILS_GREAT_CONSULTATION_SITE_SUCCESS,
                    response:
                        response, id: payload.payload.id
                }),
                put({ type: types.SET_LOADING, payload: false })
            ];
        }

    } catch (error) {
        yield [
            put({ type: types.DETAILS_GREAT_CONSULTATION_SITE_ERROR, error }),
            put({ type: types.SET_LOADING, payload: false })
        ];
    }
}
export function* deletegreatConstructionSitesSaga(payload) {
    try {
        yield [
            put({ type: types.SET_LOADING, payload: true })
        ];
        let response = yield call(deletegreatConstructionSitesService, payload);
        if (response.error) {
            yield [
                put({ type: types.DELETE_GREAT_CONSULTATION_SITE_ERROR, response: response.error }),
                put({ type: types.SET_LOADING, payload: false })
            ];

        } else {
            yield [
                put({
                    type: types.DELETE_GREAT_CONSULTATION_SITE_SUCCESS,
                    id: payload.payload.id
                }),
                put({ type: types.SET_LOADING, payload: false })
            ];
        }


    } catch (error) {
        yield [
            put({
                type: types.DELETE_GREAT_CONSULTATION_SITE_SUCCESS,
                id: payload.payload.id
            }),
            put({ type: types.SET_LOADING, payload: false })
        ];
        yield put({ type: types.DELETE_GREAT_CONSULTATION_SITE_ERROR, error });
    }
}


