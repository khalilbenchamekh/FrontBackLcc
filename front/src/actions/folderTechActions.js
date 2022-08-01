import * as types from "./index";

export const getFolderTechNaturesAction=(token)=>{
    return {
        type: types.GET_FOLDERTECH_NATURES,
        token
    }
};

export const addFolderTechNaturesAction=(token,natureName)=>{
    return {
        type: types.ADD_FOLDERTECH_NATURES,
        payload: {token: token, Name: natureName}
    }
};

export const updateFolderTechNaturesAction=(token,obj,id)=>{
    return {
        type: types.UPDATE_FOLDERTECH_NATURES,
        payload: {token: token,id:id, obj: obj}
    }
};
export const deleteFolderTechNaturesAction=(token,obj,id)=>{
    return {
        type: types.DELETE_FOLDERTECH_NATURES,
        payload: {token: token,id:id, obj: obj}
    }
};



export const addMultipleFolderTechNaturesAction=(token,multiple)=>{
    return {
        type: types.ADD_MULTIPLE_FOLDERTECH_NATURES,
        payload: {token: token, multiple: multiple}
    }
};export const getFolderTechSituationsAction=(token)=>{
    return {
        type: types.GET_FOLDERTECH_SITUATIONS,
        token
    }
};

export const addFolderTechSituationsAction=(token,obj)=>{
    return {
        type: types.ADD_FOLDERTECH_SITUATIONS,
        payload: {token: token, obj: obj}
    }
};

export const updateFolderTechSituationsAction=(token,obj,id)=>{
    return {
        type: types.UPDATE_FOLDERTECH_SITUATIONS,
        payload: {token: token,id:id, obj: obj}
    }
};
export const deleteFolderTechSituationsAction=(token,obj,id)=>{
    return {
        type: types.DELETE_FOLDERTECH_SITUATIONS,
        payload: {token: token,id:id, obj: obj}
    }
};




export const addMultipleFolderTechSituationsAction=(token,multiple)=>{
    return {
        type: types.ADD_MULTIPLE_FOLDERTECH_SITUATIONS,
        payload: {token: token, multiple: multiple}
    }
};



export const getFolderTechAction=(token)=>{
    return {
        type: types.GET_FOLDERTECH,
        token
    }
};

export const addFolderTechAction=(token,obj)=>{
    return {
        type: types.ADD_FOLDERTECH,
        payload: {token: token, obj: obj}
    }
};

export const updateFolderTechAction=(token,obj,id)=>{
    return {
        type: types.UPDATE_FOLDERTECH,
        payload: {token: token,id:id, obj: obj}
    }
};
export const deleteFolderTechAction=(token,obj,id)=>{
    return {
        type: types.DELETE_FOLDERTECH,
        payload: {token: token,id:id, obj: obj}
    }
};
