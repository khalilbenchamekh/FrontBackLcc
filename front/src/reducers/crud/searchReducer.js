import * as types from "../../actions";
import { convertToObject } from "../../utils/search/searchConverter";

export default function (state = {
    results: [],
    details: {},
    error: ""
}, action) {
    const response = action.response;
    switch (action.type) {
        case types.SET_SEARCH_RESULTS:
            return {
                ...state,
                results: typeof response.data === "object" ? convertToObject(response.data) : response.data
            };
        case types.SET_SEARCH_ERROR:
            return {
                ...state,
                error: response.error
            };
        case types.SET_SEARCH_RESULTS_DETAILS:
            return {
                ...state,
                details: typeof response.data === "object" ? convertToObject(response.data) : response.data
            };
        default:
            return state;
    }
};
