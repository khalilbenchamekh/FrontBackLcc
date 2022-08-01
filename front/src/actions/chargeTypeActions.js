import * as types from "./index";

export const getChargeNatureAction=(token)=>{
    return {
        type: types.GET_CHARGES_NATURES,
        token
    }
};

export const addChargeNatureAction=(token,obj)=>{
    return {
        type: types.ADD_CHARGES_NATURES,
        payload: {token: token, obj: obj}
    }
};
export const updateChargeNatureAction=(token,obj,id,index)=>{
    return {
        type: types.UPDATE_CHARGES_NATURES,
        payload: {token: token,id:id,
            index:index,
            obj: obj}
    }
};


export const deleteChargeNatureAction=(token,obj,id)=>{
    return {
        type: types.DELETE_CHARGES_NATURES,
        payload: {token: token,id:id, obj: obj}
    }
};

export const getChargeNatureToSelectAction=(token)=>{
    return {
        type: types.GET_CHARGES_NATURES_TO_SELECT,
        token
    }
};





