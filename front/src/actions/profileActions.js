import * as types from "./index";

export const setProfileAction = (token, obj) => {
    return {
        type: types.SET_PROFILE,
        payload: {
            token: token, obj: obj
        }

    }
};
export const setProfileFromStorageAction = (obj) => {
    return {
        type: types.SET_PROFILE_STORAGE,
        obj: obj
    }
};

export const getProfilAction = (token, data) => {
    return {
        type: types.GET_PROFILE,
        payload: {
            token: token, data: data
        }
    }
};
