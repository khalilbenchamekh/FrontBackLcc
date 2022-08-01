import { call, put } from "redux-saga/effects";
import * as types from "../../../actions";

import {
    getLog
} from "../../../services/crud/log/logServices";


export function* getLogList(payload) {

    yield [
        put({ type: types.SET_LOG_LOADING, payload: true }),
        put({ type: types.SET_LOADING, payload: true }),
        put({ type: types.SET_LOG_ERROR, payload: undefined })
    ];
    try {
        let response = yield call(getLog, payload);
        yield [
            put({ type: types.SET_LOG, payload: response }),
            put({ type: types.SET_LOADING, payload: false }),
            put({ type: types.SET_LOG_LOADING, payload: false }),
        ];
    } catch (error) {
        yield [
            put({ type: types.SET_LOG_ERROR, payload: error }),
            put({ type: types.SET_LOADING, payload: false }),
            put({ type: types.SET_LOG_LOADING, payload: false }),
        ];
    }
}