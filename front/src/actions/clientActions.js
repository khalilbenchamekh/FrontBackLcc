import * as types from "./index";

export const getClientsAction=(token)=>{
    return {
        type: types.GET_CLIENTS,
        token
    }
};

export const addClientAction=(token,obj)=>{
    return {
        type: types.ADD_CLIENT,
        payload: {token: token, obj: obj}
    }
};

export const updateClientAction=(token,obj,id)=>{
    return {
        type: types.UPDATE_CLIENT,
        payload: {token: token,id:id, obj: obj}
    }
};
export const deleteClientAction=(token,obj,id)=>{
    return {
        type: types.DELETE_CLIENT,
        payload: {token: token,id:id, obj: obj}
    }
};



export const addMultipleClientsAction=(token,multiple)=>{
    return {
        type: types.ADD_MULTIPLE_CLIENT,
        payload: {token: token, multiple: multiple}
    }
};

export const addClientsForSelectAction=(token)=>{
    return {
        type: types.GET_CLIENT_FOR_SELECT,
        payload: {token: token}
    }
};

