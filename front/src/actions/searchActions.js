import * as types from "./index";

export const findResult = (token, searchParams) => {
    return {
        type: types.GET_SEARCH_RESULTS,
        payload: {
            token: token, params: {
                searchParams
            }
        }
    }
};

export const findResultDetails = (token, searchParams) => {
    return {
        type: types.GET_SEARCH_RESULTS_DETAILS,
        payload: {
            token: token, params: {
                searchParams
            }
        }
    }
};

export const setError = (error) => {
    return {
        type: types.SET_SEARCH_ERROR,
        payload: error
    }
};


export const setResultsDetails = (details) => {
    return {
        type: types.SET_SEARCH_RESULTS,
        payload: details
    }
};
