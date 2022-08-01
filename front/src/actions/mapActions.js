import * as types from "./index";

export const getLocationsAction=(token)=>{
    return {
        type: types.GET_LOCATIONS,
        token
    }
};
