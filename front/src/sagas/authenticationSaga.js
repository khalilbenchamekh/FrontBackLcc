import {put, call} from 'redux-saga/effects';
import {
    registerUserService,
    loginUserService,
    refreshUserService,
    getProfilInfoServices, setProfileInfoServices
} from '../services/authenticationService';

import * as types from '../actions'
import {checkCookie, deleteCookie, getCookie, setCookie} from "../utils/cookies";
import {getProfilAction} from "../actions/profileActions";

export function JwtExpiredAt(expDate) {
    let d = new Date(0);
    d.setUTCSeconds(expDate);
    let dateNow = new Date();
    if (d.getDate() - dateNow.getDate() <= 3 && d.getDate() - dateNow.getDate() > 0) {
        return true;
    } else {
        return false;
    }
}

export function* checkIfAuthenticatedSaga() {
    try {
        const user = checkCookie();
        let token = getCookie('token');
        if (user !== null) {
            let res = JwtExpiredAt(user.exp);
            if (res === true) {
                try {
                    const response = yield call(refreshUserService, token);
                    yield [
                        put({type: types.REFRESH_TOKEN_SUCCESS, response}),
                    ];
                } catch (error) {
                    yield put({type: types.REFRESH_TOKEN_ERROR, error});
                }
            }

            const response = {
                token: token
            };
            yield [
                put({type: types.SET_TOKEN_SUCCESS, response}),
            ];
        }

    } catch (error) {
        alert(error);
    }
}

export function* registerSaga(payload) {
    try {
        yield [
            put({type: types.SET_LOADING, payload: true}),
        ];
        const response = yield call(registerUserService, payload);
        yield [
            put({type: types.REGISTER_USER_SUCCESS, response}),
            put({type: types.SET_LOADING, payload: false}),
        ];
    } catch (error) {
        yield [
            put({type: types.REGISTER_USER_ERROR, error}),
            put({type: types.SET_LOADING, payload: false}),
        ];
    }
}

export function* getImageProfile(payload) {
    try {
        let response = yield call(getProfilInfoServices, payload);
        if (response) {
            if (response.error) {
                let error = response.error;
                yield put({type: types.GET_PROFILE_ERROR, error});
            } else {
                let data = payload.payload.data;
                // data["avatar"] = URL.createObjectURL(response) ;
                data["avatar"] = response;
                localStorage.removeItem('avatar');
                localStorage.setItem('avatar',
                    JSON.stringify(data)
                );
                yield [
                    put({type: types.GET_PROFILE_SUCCESS, response: data}),
                ];
            }
        }

    } catch (error) {
        yield put({type: types.GET_PROFILE_ERROR, error});
    }
}

export function* setImageProfileFromStorageSaga(payload) {
    try {
        if (payload) {
            if (payload.obj) {
                let obj = payload.obj;
                yield [
                    put({type: types.GET_PROFILE_SUCCESS, response: obj}),
                ];
            }
        }
    } catch (error) {
        yield [
            put({type: types.GET_PROFILE_ERROR, error}),
        ]
    }
}

export function* setImageProfileSaga(payload) {
    try {
        yield [
            put({type: types.SET_LOADING, payload: true}),
        ];
        const response = yield call(setProfileInfoServices, payload);
        if (response) {
            if (response.data) {
                yield put(getProfilAction(payload.payload.token, response.data));
            }
        }
        yield [
            put({type: types.SET_LOADING, payload: false}),
        ];
    } catch (error) {
        yield [
            put({type: types.SET_PROFILE_ERROR, error}),
            put({type: types.SET_LOADING, payload: false}),
        ]
    }
}

export function* loginSaga(payload) {
    try {
        yield [
            put({type: types.SET_LOADING, payload: true}),
        ];
        const response = yield call(loginUserService, payload);
        if (response) {
            if (response.token && response.data) {
                yield put(getProfilAction(response.token, response.data));
            }
        }

        yield [
            put({type: types.SET_TOKEN_SUCCESS, response}),
            put({type: types.LOGIN_USER_SUCCESS, response}),
            put({type: types.SET_LOADING, payload: false}),
        ];
    } catch (error) {
        yield [
            put({type: types.LOGIN_USER_ERROR, error}),
            put({type: types.SET_LOADING, payload: false}),
        ]
    }
}
