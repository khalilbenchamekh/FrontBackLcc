import * as types from "./index";

export const getAutoCompleteAction = (token,obj,route) => {
    return {
        type: types.GET_AUTOCOMPLETE,
        payload: {token: token, obj: obj,route:route}
    }
};

