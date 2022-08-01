import {call, put} from "redux-saga/effects";

import * as types from "../../actions";
import {
    downloadFileFromService
} from "../../services/syncfusion/syncfusionService";

export function* downloadFileSaga(payload) {
    try {
      yield call(downloadFileFromService, payload);
    } catch (error) {
        yield put({type: types.GET_LOAD_TYPES_ERROR, error});
    }
}
