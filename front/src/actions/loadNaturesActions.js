import * as types from "./index";

export const getLoadNaturesAction=(token)=>{
    return {
        type: types.GET_LOAD_NATURES,
        token
    }
};

export const addLoadNaturesAction=(token,natureName)=>{
    return {
        type: types.ADD_LOAD_NATURES,
        payload: {token: token, name: natureName}
    }
};

export const updateLoadNaturesAction=(token,obj,id)=>{
    return {
        type: types.UPDATE_LOAD_NATURES,
        payload: {token: token,id:id, obj: obj}
    }
};
export const deleteLoadNaturesAction=(token,obj,id)=>{
    return {
        type: types.DELETE_LOAD_NATURES,
        payload: {token: token,id:id, obj: obj}
    }
};


export const addMultipleLoadNaturesAction=(token,multiple)=>{
    return {
        type: types.ADD_MULTIPLE_LOAD_NATURES,
        payload: {token: token, multiple: multiple}
    }
}
