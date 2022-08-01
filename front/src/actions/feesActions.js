import * as types from "./index";

export const getFolderTechByIdAction=(token)=>{
    return {
        type: types.GET_FOLDER_TECH_BY_ID,
        token
    }
};

export const getBusinessByIdAction=(token)=>{
    return {
        type: types.GET_BUSINESS_BY_ID,
        token
    }
};

export const getBusinessFeesAction=(token)=>{
    return {
        type: types.GET_BUSINESS_FEES,
        token
    }
};

export const getFolderTechFeesAction=(token)=>{
    return {
        type: types.GET_FOLDER_TECH_FEES,
        token
    }
};

export const saveBusinessFeesAction=(token,obj)=>{
    return {
        type: types.ADD_BUSINESS_FEES,
        payload: {token: token, obj: obj}
    }
};

export const saveFolderTechFeesAction=(token,obj)=>{
    return {
        type: types.ADD_FOLDER_TECH_FEES,
        payload: {token: token, obj: obj}
    }
};


export const updateBusinessFeesAction=(token,obj,id,index)=>{
    return {
        type: types.UPDATE_BUSINESS_FEES,
        payload: {token: token,id:id,
            index:index,
            obj: obj}
    }
};
export const updateFolderTechFeesAction=(token,obj,id,index)=>{
    return {
        type: types.UPDATE_FOLDER_TECH_FEES,
        payload: {token: token,id:id,
            index:index,
            obj: obj}
    }
};





