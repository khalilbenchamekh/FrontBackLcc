import * as types from "./index";

export const getChargeAction=(token)=>{
    return {
        type: types.GET_CHARGES,
        token
    }
};

export const addChargeAction=(token,obj)=>{
    return {
        type: types.ADD_CHARGES,
        payload: {token: token, obj: obj}
    }
};
export const updateChargeAction=(token,obj,id,index)=>{
    return {
        type: types.UPDATE_CHARGES,
        payload: {token: token,id:id,
            index:index,
            obj: obj}
    }
};


export const deleteChargeAction=(token,obj,id)=>{
    return {
        type: types.DELETE_CHARGES,
        payload: {token: token,id:id, obj: obj}
    }
};






