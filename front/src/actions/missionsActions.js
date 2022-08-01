import * as types from "./index";

export const getMissionsAction=(token)=>{
    return {
        type: types.GET_MISSIONS,
        token
    }
};

export const addMissionsAction=(token,obj)=>{
    return {
        type: types.ADD_MISSIONS,
        payload: {token: token, obj: obj}
    }
};

export const updateMissionsAction=(token,obj,id)=>{
    return {
        type: types.UPDATE_MISSIONS,
        payload: {token: token,id:id, obj: obj}
    }
};
export const deleteMissionsAction=(token,obj,id)=>{
    return {
        type: types.DELETE_MISSIONS,
        payload: {token: token,id:id, obj: obj}
    }
};


