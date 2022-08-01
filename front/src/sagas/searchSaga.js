import { call, put } from "redux-saga/effects";
import * as types from "../actions";
import { getSearchResultsService, getSearchResultDetailsService } from "../services/crud/search/search";


export function* getSearchResultsSaga(payload) {
    try {
        yield [
            put({ type: types.SET_LOADING, payload: true })
        ];
        let response = yield call(getSearchResultsService, payload);

        yield [
            put({ type: types.SET_SEARCH_RESULTS, response }),
            put({ type: types.SET_LOADING, payload: false })
        ];
    } catch (error) {
        yield [
            put({ type: types.SET_SEARCH_ERROR, error }),
            put({ type: types.SET_LOADING, payload: false })
        ];
    }
}

export function* getSearchResultDetailsSaga(payload) {
    try {
        yield [
            put({ type: types.SET_LOADING, payload: true })
        ];
        let response = yield call(getSearchResultDetailsService, payload);

        yield [
            put({ type: types.SET_SEARCH_RESULTS_DETAILS, response }),
            put({ type: types.SET_LOADING, payload: false })
        ];
    } catch (error) {
        yield [
            put({ type: types.SET_SEARCH_ERROR, error }),
            put({ type: types.SET_LOADING, payload: false })
        ];
    }
}