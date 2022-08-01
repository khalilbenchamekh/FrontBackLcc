import {call, put} from "redux-saga/effects";
import * as types from "../../../actions";
import {
    addEmployeeService, deleteEmployeeService, downloadEmployeeDocumentService,
    getEmployeeService,
    updateEmployeeService
} from "../../../services/crud/employee/emplyeeServices";

export function* getEmployeeSaga(payload) {
    try {
        yield [
            put({type: types.SET_LOADING, payload: true})
        ];
        let response = yield call(getEmployeeService, payload);

        yield [
            put({type: types.GET_EMPLOYEES_SUCCESS, response}),
            put({type: types.SET_LOADING, payload: false})
        ];
    } catch (error) {
        yield [
            put({type: types.GET_EMPLOYEES_ERROR, error}),
            put({type: types.SET_LOADING, payload: false})
        ];
    }
}

export function* downloadEmployeeDocumentSaga(payload) {
    try {
        let response = yield call(downloadEmployeeDocumentService, payload);

    } catch (error) {
        yield put({type: types.DOWNLOAD_EMPLOYEE_DOCUMENTS_ERROR, error});
    }
}

export function* addEmployeeSaga(payload) {
    try {
        yield [
            put({type: types.SET_LOADING, payload: true})
        ];
        let response = yield call(addEmployeeService, payload);

        yield [
            put({type: types.ADD_EMPLOYEE_SUCCESS, response}),
            put({type: types.SET_LOADING, payload: false})
        ];
    } catch (error) {
        yield [
            put({type: types.ADD_EMPLOYEE_ERROR, error}),
            put({type: types.SET_LOADING, payload: false})
        ];
    }
}

export function* updateEmployeeSaga(payload) {
    try {
        yield [
            put({type: types.SET_LOADING, payload: true})
        ];
        let response = yield call(updateEmployeeService, payload);
        if (response.error) {
            yield [
                put({type: types.UPDATE_EMPLOYEE_ERROR, response: response.error}),
                put({type: types.SET_LOADING, payload: false})
            ];

        } else {
            yield [
                put({
                    type: types.UPDATE_EMPLOYEE_SUCCESS,
                    response:
                    response, id: payload.payload.id
                }),
                put({type: types.SET_LOADING, payload: false})
            ];
        }

    } catch (error) {
        yield [
            put({type: types.UPDATE_EMPLOYEE_ERROR, error}),
            put({type: types.SET_LOADING, payload: false})
        ];
    }
}

export function* deleteEmployeeSaga(payload) {
    try {
        yield [
            put({type: types.SET_LOADING, payload: true})
        ];
        let response = yield call(deleteEmployeeService, payload);
        if (response.error) {
            yield [
                put({type: types.DELETE_EMPLOYEE_ERROR, response: response.error}),
                put({type: types.SET_LOADING, payload: false})
            ];

        } else {
            yield [
                put({
                    type: types.DELETE_EMPLOYEE_SUCCESS,
                    id: payload.payload.id
                }),
                put({type: types.SET_LOADING, payload: false})
            ];
        }


    } catch (error) {
        yield [
            put({
                type: types.DELETE_EMPLOYEE_SUCCESS,
                id: payload.payload.id
            }),
            put({type: types.SET_LOADING, payload: false})
        ];
        yield put({type: types.DELETE_EMPLOYEE_ERROR, error});
    }
}

