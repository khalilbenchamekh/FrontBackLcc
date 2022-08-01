import * as types from "../../actions";
import { updateObjectInArray} from "../../utils";
import {makeOptionForChart} from "../../utils/greatConstructionSiteActions/Satistics";

export default function (state = {
    error: '',
    statistics: [],
    site:{},
    sites: [],
}, action) {
    const response = action.response;
    switch (action.type) {
        case types.GET_GREAT_CONSULTATION_SITE_SUCCESS:
            return {...state, sites: response.data};
        case types.GET_GREAT_CONSULTATION_SITE_ERROR:
            return {
                ...state,
                error:  response.error
            };
        case types.ADD_GREAT_CONSULTATION_SITE_SUCCESS:
            return {
                ...state,
                sites: state.sites.concat(response.data)
            };
        case types.ADD_GREAT_CONSULTATION_SITE_ERROR:
            return {
                ...state,
                error:  response.error

            };
        case types.UPDATE_GREAT_CONSULTATION_SITE_SUCCESS:
            return {
                ...state,
                sites: updateObjectInArray(state.sites, response.data, action.id)
            };
        case types.DELETE_GREAT_CONSULTATION_SITE_SUCCESS:
            return {
                ...state,
                sites : state.sites.filter( (item, index) => index !== action.id)
            };

            case types.DELETE_GREAT_CONSULTATION_SITE_ERROR:
            return {
                ...state,
                error:  response.error
            };
              case types.DETAILS_GREAT_CONSULTATION_SITE_SUCCESS:
            return {
                ...state,
                site:  response.data
            };   case types.DETAILS_GREAT_CONSULTATION_SITE_ERROR:
            return {
                ...state,
                error:  response.error
            };
            case types.GET_STATISTIQUES_GREAT_CONSULTATION_SITE_SUCCESS:
            return {
                ...state,
                statistics: makeOptionForChart(response.data)
            };   case types.GET_STATISTIQUES_GREAT_CONSULTATION_SITE_ERROR:
            return {
                ...state,
                error:  response.error
            };
        default:
            return state;
    }
};
