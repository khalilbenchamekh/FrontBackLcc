import * as types from "./index";

export const getRouteToProtectAction=(token)=>{
    return {
        type: types.GET_ROUTE_TO_PROTECT,
        token
    }
};

export const getUsersWithPermissionsAction=(token,route_name)=>{
    return {
        type: types.GET_USER_WITH_PERMISSION,
        payload: {token: token, route_name: route_name}
    }
};
export const setUsersWithPermissionsAction=(token,route_name,action,id,checked)=>{
    return {
        type: types.SET_USER_WITH_PERMISSION,
        payload: {token: token, route_name: route_name,
            action:action,id:id,
            checked:checked
        }
    }
};
export const getSatitstiquesAction=(token)=>{
    return {
        type: types.GET_STATISTIQUES_TO_ADMIN,
        payload: {token: token}
    }
};
