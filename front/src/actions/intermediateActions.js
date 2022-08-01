import * as types from "./index";

export const getIntermediatesAction=(token)=>{
    return {
        type: types.GET_INTERMEDIATES,
        token
    }
};

export const addIntermediateAction=(token,obj)=>{
    return {
        type: types.ADD_INTERMEDIATE,
        payload: {token: token, obj: obj}
    }
};

export const updateIntermediateAction=(token,obj,id)=>{
    return {
        type: types.UPDATE_INTERMEDIATE,
        payload: {token: token,id:id, obj: obj}
    }
};
export const deleteIntermediateAction=(token,obj,id)=>{
    return {
        type: types.DELETE_INTERMEDIATE,
        payload: {token: token,id:id, obj: obj}
    }
};



export const addMultipleIntermediatesAction=(token,multiple)=>{
    return {
        type: types.ADD_MULTIPLE_INTERMEDIATE,
        payload: {token: token, multiple: multiple}
    }
};
