import * as types from "./index";


export const getLoadTypeAction=(token)=>{
    return {
        type: types.GET_LOAD_TYPES,
        payload: {token: token}
    }
};

export const getLoadRelatedToAction=(token)=>{
    return {
        type: types.GET_LOAD_RELATED_TO,
        payload: {token: token}
    }
};

export const getLocationAction=(token)=>{
    return {
        type: types.GET_LOCATION,
        payload: {token: token}
    }
};

export const getAllocatedBrigadesAction=(token)=>{
    return {
        type: types.GET_ALL_LOCATED_BRIGADES,
        payload: {token: token}
    }
};

export const getClientByIdAction=(token)=>{
    return {
        type: types.GET_CLIENT_BY_ID,
        payload: {token: token}
    }
};

export const getBusinessNaturesByIdAction=(token)=>{
    return {
        type: types.GET_BUSINESS_NATURE_BY_NAME,
        payload: {token: token}
    }
};

export const getFolderNaturesByNameAction=(token)=>{
    return {
        type: types.GET_FOLDER_TECH_NATURE_BY_NAME,
        payload: {token: token}
    }
};


export const getFolderSituationByIdAction=(token)=>{
    return {
        type: types.GET_FOLDER_TECH_SITUATION_BY_ID,
        payload: {token: token}
    }
};export const getBusinessSituationByIdAction=(token)=>{
    return {
        type: types.GET_BUSINESS_SITUATION_BY_ID,
        payload: {token: token}
    }
};

export const getIntermediatesByIdAction=(token)=>{
    return {
        type: types.GET_INTERMEDIATES_BY_ID,
        payload: {token: token}
    }
};
