import * as types from "./index";

export const getGreatConstructionSitesAction = (token) => {
    return {
        type: types.GET_GREAT_CONSULTATION_SITE,
        token
    }
};

export const addGreatConstructionSitesAction = (token, obj, responseToReplace) => {
    return {
        type: types.ADD_GREAT_CONSULTATION_SITE,
        payload: {
            token: token,
            responseToReplace: {
                data: responseToReplace
            },
            obj: obj
        }
    }
};
export const updateGreatConstructionSitesAction = (token, obj, id ,responseToReplace) => {
    return {
        type: types.UPDATE_GREAT_CONSULTATION_SITE,
        payload: {token: token, id: id,
            responseToReplace: {
                data: responseToReplace
            },
            obj: obj}
    }
};
export const getDatailsGreatConstructionSitesAction = (token, id) => {
    return {
        type: types.DETAILS_GREAT_CONSULTATION_SITE,
        payload: {token: token, id: id}
    }
};
export const getSatitstiquesGreatConstructionSitesAction = (token) => {
    return {
        type: types.GET_STATISTIQUES_GREAT_CONSULTATION_SITE,
        payload: {token: token}
    }
};

export const deleteGreatConstructionSitesAction = (token, obj, id) => {
    return {
        type: types.DELETE_GREAT_CONSULTATION_SITE,
        payload: {token: token, id: id, obj: obj}
    }
};






