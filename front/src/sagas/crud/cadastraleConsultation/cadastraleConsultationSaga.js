import { call, put } from "redux-saga/effects";
import * as types from "../../../actions";
import {
    addMultiCadastraleConsultationService,
    getCadastraleConsultationService
} from "../../../services/crud/cadastraleConsultation/cadastraleConsultationService";


export function* getCadastraleConsultationSaga(payload) {
    try {
        yield [
            put({ type: types.SET_LOADING, payload: true })
        ];
        let response = yield call(getCadastraleConsultationService, payload);

        yield [
            put({ type: types.GET_GREAT_CADASTRAL_CONSULTATION_SUCCESS, response }),
            put({ type: types.SET_LOADING, payload: false })
        ];
    } catch (error) {
        yield [
            put({ type: types.GET_GREAT_CADASTRAL_CONSULTATION_ERROR, error }),
            put({ type: types.SET_LOADING, payload: false })
        ];
    }
}

export function* addMultiCadastraleConsultationSaga(payload) {
    try {
        yield [
            put({ type: types.SET_LOADING, payload: true })
        ];
        let response = yield call(addMultiCadastraleConsultationService, payload);
        if (response.error) {
            yield [
                put({ type: types.ADD_MULTIPLE_CADASTRAL_CONSULTATION_ERROR, response: response.error }),
                put({ type: types.SET_LOADING, payload: false })
            ];;

        } else {
            yield [
                put({ type: types.ADD_MULTIPLE_CADASTRAL_CONSULTATION_SUCCESS, response }),
                put({ type: types.SET_LOADING, payload: false })
            ];
        }

    } catch (error) {
        yield [
            put({ type: types.ADD_MULTIPLE_CADASTRAL_CONSULTATION_ERROR, error }),
            put({ type: types.SET_LOADING, payload: false })
        ];
    }
}
