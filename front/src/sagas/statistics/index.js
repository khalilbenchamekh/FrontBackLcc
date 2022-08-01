import { call, put } from "redux-saga/effects";
import * as types from "../../actions";

import {
    getStatistics
} from "../../services/statistics/statisticsService";


export function* getStatisticsInfo(payload) {
    yield [
        put({ type: types.SET_LOADING, payload: true }),
        put({ type: types.SET_STATISTICS_ERROR, payload: undefined })
    ];
    try {
        let response = yield call(getStatistics, payload);
        yield [
            put({ type: types.SET_STATISTICS, payload: response }),
            put({ type: types.SET_LOADING, payload: false }),
        ];
    } catch (error) {
        yield [
            put({ type: types.SET_STATISTICS_ERROR, payload: error }),
            put({ type: types.SET_LOADING, payload: false }),
        ];
    }
}