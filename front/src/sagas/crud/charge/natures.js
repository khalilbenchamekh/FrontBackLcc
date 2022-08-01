import {call, put} from "redux-saga/effects";
import * as types from "../../../actions";
import {
    addChargeTypesNaturesService, deleteChargeTypesNaturesService,
    getChargeTypesNaturesService, updateChargeTypesNaturesService
} from "../../../services/crud/Charges/natureChargeServices";


export function* getChargeTypesNaturesSaga(payload) {
    try {
        yield [
            put({type: types.SET_LOADING, payload: true})
        ];
        let response = yield call(getChargeTypesNaturesService, payload);
        if (response.data) {
            yield [
                put({type: types.GET_CHARGES_NATURES_SUCCESS, response}),
                put({type: types.SET_LOADING, payload: false})
            ];
        }

    } catch (error) {
        yield [
            put({type: types.GET_CHARGES_NATURES_ERROR, error}),
            put({type: types.SET_LOADING, payload: false})
        ];
    }
}

export function* getChargeTypesNaturesToSelectSaga(payload) {
    try {
        yield [
            put({type: types.SET_LOADING, payload: true})
        ];
        let response = yield call(getChargeTypesNaturesService, payload);
        if (response.data) {
            yield [
                put({type: types.GET_CHARGES_NATURES_TO_SELECT_SUCCESS, response}),
                put({type: types.SET_LOADING, payload: false})
            ];
        }

    } catch (error) {
        yield [
            put({type: types.GET_CHARGES_NATURES_TO_SELECT_ERROR, error}),
            put({type: types.SET_LOADING, payload: false})
        ];
    }
}


export function* addChargeTypesNaturesSaga(payload) {
    try {
        yield [
            put({type: types.SET_LOADING, payload: true})
        ];
        let response = yield call(addChargeTypesNaturesService, payload);

        yield [
            put({type: types.ADD_CHARGES_NATURES_SUCCESS, response}),
            put({type: types.SET_LOADING, payload: false})
        ];
    } catch (error) {
        yield [
            put({type: types.ADD_CHARGES_NATURES_ERROR, error}),
            put({type: types.SET_LOADING, payload: false})
        ];
    }
}

export function* updateChargeTypesNaturesSaga(payload) {
    try {
        yield [
            put({type: types.SET_LOADING, payload: true})
        ];
        let response = yield call(updateChargeTypesNaturesService, payload);
        if (response.error) {
            yield [
                put({type: types.UPDATE_CHARGES_NATURES_ERROR, response: response.error}),
                put({type: types.SET_LOADING, payload: false})
            ];

        } else {
            yield [
                put({
                    type: types.UPDATE_CHARGES_NATURES_SUCCESS,
                    response:
                    response, id: payload.payload.id
                }),
                put({type: types.SET_LOADING, payload: false})
            ];
        }

    } catch (error) {
        yield [
            put({type: types.UPDATE_CHARGES_NATURES_ERROR, error}),
            put({type: types.SET_LOADING, payload: false})
        ];
    }
}

export function* deleteChargeTypesNaturesSaga(payload) {
    try {
        yield [
            put({type: types.SET_LOADING, payload: true})
        ];
        let response = yield call(deleteChargeTypesNaturesService, payload);
        if (response.error) {
            yield [
                put({type: types.DELETE_CHARGES_NATURES_ERROR, response: response.error}),
                put({type: types.SET_LOADING, payload: false})
            ];

        } else {
            yield [
                put({
                    type: types.DELETE_CHARGES_NATURES_SUCCESS,
                    id: payload.payload.id
                }),
                put({type: types.SET_LOADING, payload: false})
            ];
        }


    } catch (error) {
        yield [
            put({
                type: types.DELETE_CHARGES_NATURES_SUCCESS,
                id: payload.payload.id
            })
        ];
        yield put({type: types.DELETE_CHARGES_NATURES_ERROR, error});
    }
}

