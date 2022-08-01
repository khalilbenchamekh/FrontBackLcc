import * as types from "./index";

export const getEmployeesAction = token => {
    return {
        type: types.GET_EMPLOYEES,
        token
    };
};

export const addEmployeeAction = (token, obj) => {
    return {
        type: types.ADD_EMPLOYEE,
        payload: {token: token, obj: obj}
    };
};

export const updateEmployeeAction = (token, obj, id) => {
    return {
        type: types.UPDATE_EMPLOYEE,
        payload: {token: token, id: id, obj: obj}
    };
};
export const deleteEmployeeAction = (token, obj, id) => {
    return {
        type: types.DELETE_EMPLOYEE,
        payload: {token: token, id: id, obj: obj}
    };
};

export const downloadEmployeeDocumentsAction = (token, username, filename) => {
    return {
        type: types.DOWNLOAD_EMPLOYEE_DOCUMENTS,
        payload: {
            token: token,
            obj: {filename: filename, username: username}
        }
    };
};

