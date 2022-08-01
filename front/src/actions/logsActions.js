import * as types from "./index";
export const getLog = (token) => {
    return {
        type: types.GET_LOG,
        payload: token
    }
};