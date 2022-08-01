import * as types from "./index";
export const searchStatistics = (token, searchParams) => {
    return {
        type: types.GET_STATISTICS,
        payload: { token, searchParams }
    }
};
export const setRapportSelected = (selected) => {
    return {
        type: types.SET_STATISTICS_RAPPORT_SELECTED,
        payload: selected,
    }
};
export const searchSelectedStatistics = (selected) => {
    return {
        type: types.GET_STATISTICS,
        payload: { ...selected }
    }
};