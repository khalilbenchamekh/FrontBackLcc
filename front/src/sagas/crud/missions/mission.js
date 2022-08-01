import { call, put } from "redux-saga/effects";
import * as types from "../../../actions";
import {
    addMissionsService,
    deleteMissionsService, getMissionsService,
    updateMissionsService
} from "../../../services/crud/missions/missionService";

export function* getMissionsSaga(payload) {
    try {
        yield [
            put({ type: types.SET_LOADING, payload: true })
        ];
        let response = yield call(getMissionsService, payload);
        if (response.data) {
            yield [
                put({ type: types.GET_MISSIONS_SUCCESS, response }),
                put({ type: types.SET_LOADING, payload: false })
            ];
        } else {
            yield [
                put({ type: types.GET_MISSIONS_ERROR, error: response.error }),
                put({ type: types.SET_LOADING, payload: false })
            ];

        }

    } catch (error) {
        yield [
            put({ type: types.GET_MISSIONS_ERROR, error }),
            put({ type: types.SET_LOADING, payload: false })
        ];
    }
}
export function* addMissionsSaga(payload) {
    try {
        yield [
            put({ type: types.SET_LOADING, payload: true })
        ];
        let response = yield call(addMissionsService, payload);
        if (response.data) {
            yield [
                put({ type: types.ADD_MISSIONS_SUCCESS, response }),
                put({ type: types.SET_LOADING, payload: false })
            ];
        } else {
            yield [
                put({ type: types.ADD_MISSIONS_ERROR, error: response.error }),
                put({ type: types.SET_LOADING, payload: false })
            ];

        }

    } catch (error) {
        yield [
            put({ type: types.ADD_MISSIONS_ERROR, error }),
            put({ type: types.SET_LOADING, payload: false })
        ];
    }
}
export function* updateMissionsSaga(payload) {
    try {
        yield [
            put({ type: types.SET_LOADING, payload: true })
        ];
        let response = yield call(updateMissionsService, payload);
        if (response.error) {
            yield [
                put({ type: types.UPDATE_MISSIONS_ERROR, response: response.error }),
                put({ type: types.SET_LOADING, payload: false })
            ];

        } else {
            yield [
                put({
                    type: types.UPDATE_MISSIONS_SUCCESS,
                    response:
                        response, id: payload.payload.id
                }),
                put({ type: types.SET_LOADING, payload: false })
            ];
        }

    } catch (error) {
        yield [
            put({ type: types.UPDATE_MISSIONS_ERROR, error }),
            put({ type: types.SET_LOADING, payload: false })
        ];
    }
}
export function* deleteMissionsSaga(payload) {
    try {
        yield [
            put({ type: types.SET_LOADING, payload: true })
        ];
        let response = yield call(deleteMissionsService, payload);
        if (response.error) {
            yield [
                put({ type: types.DELETE_MISSIONS_ERROR, response: response.error }),
                put({ type: types.SET_LOADING, payload: false })
            ];

        } else {
            yield [
                put({
                    type: types.DELETE_MISSIONS_SUCCESS,
                    id: payload.payload.id
                }),
                put({ type: types.SET_LOADING, payload: false })
            ];
        }


    } catch (error) {
        yield [
            put({
                type: types.DELETE_MISSIONS_SUCCESS,
                id: payload.payload.id
            }),
            put({ type: types.SET_LOADING, payload: false })
        ];
        yield put({ type: types.DELETE_MISSIONS_ERROR, error });
    }
}

