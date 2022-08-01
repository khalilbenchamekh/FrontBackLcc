import {put, call} from 'redux-saga/effects';

import * as types from '../../actions'
import {
    getRouteToProtectService, getSatitstiquesService,
    getUsersWithPermissionsService,
    setUsersWithPermissionsService
} from "../../services/adminResourceService";
import {getAutoCompleteService} from "../../services/autoComplete";

export function* getAutoCompleteSaga(payload) {
    try {


        let response = yield call(getAutoCompleteService, payload);
        if (response.error) {
            yield put({type: types.GET_AUTOCOMPLETE_ERROR, response: response.error});

        } else {
            yield [
                put({type: types.GET_AUTOCOMPLETE_SUCCESS, response})
            ];
        }

    } catch (error) {
        yield put({type: types.GET_AUTOCOMPLETE_ERROR, error});
    }
}

export function* getRouteToProtectSaga(payload) {
    try {
        let response = yield call(getRouteToProtectService, payload);
        if (response) {
            if (response.length > 0) {
                yield [
                    put({type: types.GET_ROUTE_TO_PROTECT_SUCCESS, response})
                ];
            }
        }

    } catch (error) {
        yield put({type: types.GET_ROUTE_TO_PROTECT_ERROR, error});
    }
}

export function* getUsersWithPermissionsSaga(payload) {
    try {
        let pay = payload.payload;
        yield [
            put({type: types.HANDL_MULTI_CHANGE, route_name:pay.route_name})
        ];
        let response = yield call(getUsersWithPermissionsService, pay);
        if (response) {
            if (response.length > 0) {
                yield [
                    put({type: types.GET_USER_WITH_PERMISSION_SUCCESS, response})
                ];
            } else {
                let error = 'no date';
                yield put({type: types.GET_USER_WITH_PERMISSION_ERROR, error});

            }
        }

    } catch (error) {
        yield put({type: types.GET_USER_WITH_PERMISSION_ERROR, error});
    }
}
export function* getSatitstiquesSaga(payload) {
    try {
        let response = yield call(getSatitstiquesService,payload);
        if(response.error){
            yield put({ type: types.GET_STATISTIQUES_TO_ADMIN_ERROR,response: response.error });

        }else{
            yield [
                put({ type: types.GET_STATISTIQUES_TO_ADMIN_SUCCESS,
                    response:
                    response ,id:payload.payload.id})
            ];
        }

    } catch(error) {
        yield put({ type: types.GET_STATISTIQUES_TO_ADMIN_ERROR, error });
    }
}

export function* setUsersWithPermissionsSaga(payload) {
    try {
        let pay = payload.payload;
        let response = yield call(setUsersWithPermissionsService, pay);
        if (response) {
            if (response.data > 0) {
                yield [
                    put({type: types.SET_USER_WITH_PERMISSION_SUCCESS, response})
                ];
            } else {
                yield put({type: types.SET_USER_WITH_PERMISSION_ERROR, response});
            }
        }

    } catch (error) {
        yield put({type: types.SET_USER_WITH_PERMISSION_ERROR, error});
    }
}
