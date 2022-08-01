import {call, put} from "redux-saga/effects";

import * as types from "../../actions";
import {
    getAllocatedBrigadesService,
    getBusinessNaturesByIdService,
    getBusinessSituationByIdService, getClientByIdService, getFolderNaturesByNameService, getFolderSituationByIdService,
    getIntermediatesByIdService,
    getLoadRelatedToService,
    getLoadTypeService,
    getLocationsAutoCompleteService
} from "../../services/select/selectService";

export function* getLoadTypeSaga(payload) {
    try {

        let response = yield call(getLoadTypeService, payload);
        if (response.data) {
            yield [
                put({type: types.GET_LOAD_TYPES_SUCCESS, response})

            ];
        } else {
            yield put({type: types.GET_LOAD_TYPES_ERROR, error: response.error});

        }

    } catch (error) {
        yield put({type: types.GET_LOAD_TYPES_ERROR, error});
    }
}

export function* getLoadRelatedToSaga(payload) {
    try {

        let response = yield call(getLoadRelatedToService, payload);
        if (response.data) {
            yield [
                put({type: types.GET_LOAD_RELATED_TO_SUCCESS, response})

            ];
        } else {
            yield put({type: types.GET_LOAD_RELATED_TO_ERROR, error: response.error});

        }

    } catch (error) {
        yield put({type: types.GET_LOAD_RELATED_TO_ERROR, error});
    }
}

export function* getLocationSaga(payload) {
    try {

        let response = yield call(getLocationsAutoCompleteService, payload);
        if (response.data) {
            yield [
                put({type: types.GET_LOCATION_SUCCESS, response})

            ];
        } else {
            yield put({type: types.GET_LOCATION_ERROR, error: response.error});

        }

    } catch (error) {
        yield put({type: types.GET_LOCATION_ERROR, error});
    }
}

export function* getAllocatedBrigadesSaga(payload) {
    try {

        let response = yield call(getAllocatedBrigadesService, payload);
        if (response.data) {
            yield [
                put({type: types.GET_ALL_LOCATED_BRIGADES_SUCCESS, response})

            ];
        } else {
            yield put({type: types.GET_ALL_LOCATED_BRIGADES_ERROR, error: response.error});

        }

    } catch (error) {
        yield put({type: types.GET_ALL_LOCATED_BRIGADES_ERROR, error});
    }
}

export function* getClientByIdSaga(payload) {
    try {

        let response = yield call(getClientByIdService, payload);
        if (response.data) {
            yield [
                put({type: types.GET_CLIENT_BY_ID_SUCCESS, response})

            ];
        } else {
            yield put({type: types.GET_CLIENT_BY_ID_ERROR, error: response.error});

        }

    } catch (error) {
        yield put({type: types.GET_CLIENT_BY_ID_ERROR, error});
    }
}

export function* getBusinessNaturesByIdSaga(payload) {
    try {

        let response = yield call(getBusinessNaturesByIdService, payload);
        if (response.data) {
            yield [
                put({type: types.GET_BUSINESS_NATURE_BY_NAME_SUCCESS, response})

            ];
        } else {
            yield put({type: types.GET_BUSINESS_NATURE_BY_NAME_ERROR, error: response.error});

        }

    } catch (error) {
        yield put({type: types.GET_BUSINESS_NATURE_BY_NAME_ERROR, error});
    }
}

export function* getFolderNaturesByNameSaga(payload) {
    try {

        let response = yield call(getFolderNaturesByNameService, payload);
        if (response.data) {
            yield [
                put({type: types.GET_FOLDER_TECH_NATURE_BY_NAME_SUCCESS, response})
            ];
        } else {
            yield put({type: types.GET_FOLDER_TECH_NATURE_BY_NAME_ERROR, error: response.error});

        }

    } catch (error) {
        yield put({type: types.GET_BUSINESS_NATURE_BY_NAME_ERROR, error});
    }
}

export function* getBusinessSituationByIdSaga(payload) {
    try {

        let response = yield call(getBusinessSituationByIdService, payload);
        if (response.data) {
            yield [
                put({type: types.GET_BUSINESS_SITUATION_BY_ID_SUCCESS, response})

            ];
        } else {
            yield put({type: types.GET_BUSINESS_SITUATION_BY_ID_ERROR, error: response.error});

        }

    } catch (error) {
        yield put({type: types.GET_BUSINESS_SITUATION_BY_ID_ERROR, error});
    }
}

export function* getFolderSituationByIdSaga(payload) {
    try {

        let response = yield call(getFolderSituationByIdService, payload);
        if (response.data) {
            yield [
                put({type: types.GET_FOLDER_TECH_SITUATION_BY_ID_SUCCESS, response})

            ];
        } else {
            yield put({type: types.GET_FOLDER_TECH_SITUATION_BY_ID_ERROR, error: response.error});

        }

    } catch (error) {
        yield put({type: types.GET_BUSINESS_SITUATION_BY_ID_ERROR, error});
    }
}

export function* getIntermediatesByIdSaga(payload) {
    try {
        let response = yield call(getIntermediatesByIdService, payload);
        if (response.data) {
            yield [
                put({type: types.GET_INTERMEDIATES_BY_ID_SUCCESS, response})
            ];
        } else {
            yield put({type: types.GET_INTERMEDIATES_BY_ID_ERROR, error: response.error});
        }
    } catch (error) {
        yield put({type: types.GET_INTERMEDIATES_BY_ID_ERROR, error});
    }
}
