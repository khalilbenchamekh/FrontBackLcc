import * as types from "../../actions";
import { updateObjectInArray} from "../../utils";
import {makeOptionForChart} from "../../utils/greatConstructionSiteActions/Satistics";

export default function (state = {
    error: '',
    statistics: [],
    load:{},
    loads: [],
}, action) {
    const response = action.response;
    switch (action.type) {
        case types.GET_LOAD_SUCCESS:
            return {...state, loads: response.data};
        case types.GET_LOAD_ERROR:
            return {
                ...state,
                error:  response.error
            };
        case types.ADD_LOAD_SUCCESS:
            return {
                ...state,
                loads: state.loads.concat(response.data)
            };
        case types.ADD_LOAD_ERROR:
            return {
                ...state,
                error:  response.error

            };
        case types.UPDATE_LOAD_SUCCESS:
            return {
                ...state,
                loads: updateObjectInArray(state.loads, response.data, action.id)
            };
        case types.DELETE_LOAD_SUCCESS:
            return {
                ...state,
                loads : state.loads.filter( (item, index) => index !== action.id)
            };

        case types.DELETE_LOAD_ERROR:
            return {
                ...state,
                error:  response.error
            };
        case types.GET_STATISTIQUES_LOAD_SUCCESS:
            return {
                ...state,
                statistics: makeOptionForChart(response.data)
            };   case types.GET_STATISTIQUES_LOAD_ERROR:
            return {
                ...state,
                error:  response.error
            };
        default:
            return state;
    }
};
