import * as types from "./index";

export const addCadastraleConsultationAction = (token, multiple) => {
    return {
        type: types.ADD_MULTIPLE_CADASTRAL_CONSULTATION,
        payload: {token: token, multiple: multiple}
    }
};

export const getCadastraleConsultationAction = (token) => {
    return {
        type: types.GET_GREAT_CADASTRAL_CONSULTATION,
        token: token
    }
};
