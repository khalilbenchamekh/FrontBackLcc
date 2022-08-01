import * as types from "./index";

export const getBusinessNaturesAction=(token)=>{
    return {
        type: types.GET_BUSINESS_NATURES,
        token
    }
};

export const addBusinessNaturesAction=(token,natureName)=>{
    return {
        type: types.ADD_BUSINESS_NATURES,
        payload: {token: token, Name: natureName}
    }
};

export const updateBusinessNaturesAction=(token,obj,id)=>{
    return {
        type: types.UPDATE_BUSINESS_NATURES,
        payload: {token: token,id:id, obj: obj}
    }
};
export const deleteBusinessNaturesAction=(token,obj,id)=>{
    return {
        type: types.DELETE_BUSINESS_NATURES,
        payload: {token: token,id:id, obj: obj}
    }
};


export const addMultipleBusinessNaturesAction=(token,multiple)=>{
    return {
        type: types.ADD_MULTIPLE_BUSINESS_NATURES,
        payload: {token: token, multiple: multiple}
    }
};export const getBusinessSituationsAction=(token)=>{
    return {
        type: types.GET_BUSINESS_SITUATIONS,
        token
    }
};

export const addBusinessSituationsAction=(token,obj)=>{
    return {
        type: types.ADD_BUSINESS_SITUATIONS,
        payload: {token: token, obj: obj}
    }
};

export const updateBusinessSituationsAction=(token,obj,id)=>{
    return {
        type: types.UPDATE_BUSINESS_SITUATIONS,
        payload: {token: token,id:id, obj: obj}
    }
};
export const deleteBusinessSituationsAction=(token,obj,id)=>{
    return {
        type: types.DELETE_BUSINESS_SITUATIONS,
        payload: {token: token,id:id, obj: obj}
    }
};




export const addMultipleBusinessSituationsAction=(token,multiple)=>{
    return {
        type: types.ADD_MULTIPLE_BUSINESS_SITUATIONS,
        payload: {token: token, multiple: multiple}
    }
};


export const getBusinessAction=(token)=>{
    return {
        type: types.GET_BUSINESS,
        token
    }
};

export const addBusinessAction=(token,obj)=>{
    return {
        type: types.ADD_BUSINESS,
        payload: {token: token, obj: obj}
    }
};

export const updateBusinessAction=(token,obj,id)=>{
    return {
        type: types.UPDATE_BUSINESS,
        payload: {token: token,id:id, obj: obj}
    }
};
export const deleteBusinessAction=(token,obj,id)=>{
    return {
        type: types.DELETE_BUSINESS,
        payload: {token: token,id:id, obj: obj}
    }
};




export const addMultipleBusinessAction=(token,multiple)=>{
    return {
        type: types.ADD_MULTIPLE_BUSINESS,
        payload: {token: token, multiple: multiple}
    }
};
