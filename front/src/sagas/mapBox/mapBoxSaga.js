import * as types from "../../actions";
import {call, put,select} from "redux-saga/effects";
import {getLocationService} from "../../services/dashboard/locationService";

export function* getLocationsSaga(payload) {

    try {
        let response = yield call(getLocationService, payload);
        if(response.data){
            yield [
                put({
                    type: types.GET_LOCATIONS_SUCCESS,response: {locations: response.data}
                })
            ];
        }else{

            yield [
                put({
                    type: types.GET_LOCATIONS_ERROR,response: {error: response}
                })
            ];
        }


    } catch (error) {
        yield put({type: types.GET_LOCATIONS_ERROR, error});
    }
}
