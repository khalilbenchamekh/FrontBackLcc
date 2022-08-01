import * as types from "./index";

export const getLoadAction=(token)=>{
    return {
        type: types.GET_LOAD,
        token
    }
};

export const addLoadAction=(token,obj)=>{
    return {
        type: types.ADD_LOAD,
        payload: {token: token, obj: obj}
    }
};
export const updateLoadAction=(token,obj,id,index)=>{
    return {
        type: types.UPDATE_LOAD,
        payload: {token: token,id:id,
            index:index,
            obj: obj}
    }
};

export const getSatitstiquesLoadAction=(token)=>{
    return {
        type: types.GET_STATISTIQUES_LOAD,
        payload: {token: token}
    }
};

export const deleteLoadAction=(token,obj,id)=>{
    return {
        type: types.DELETE_LOAD,
        payload: {token: token,id:id, obj: obj}
    }
};






