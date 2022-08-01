import * as types from "../../actions";
import { updateObjectInArray} from "../../utils";
import {makeOptionForChart} from "../../utils/greatConstructionSiteActions/Satistics";

export default function (state = {
    error: '',
    statistics: [],
    charge:{},
    charges: [],
}, action) {
    const response = action.response;
    switch (action.type) {
        case types.GET_CHARGES_SUCCESS:
            return {...state, charges: response.data};
        case types.GET_CHARGES_ERROR:
            return {
                ...state,
                error:  response.error
            };
        case types.ADD_CHARGES_SUCCESS:
            return {
                ...state,
                charges: state.charges.concat(response.data)
            };
        case types.ADD_CHARGES_ERROR:
            return {
                ...state,
                error:  response.error

            };
        case types.UPDATE_CHARGES_SUCCESS:
            return {
                ...state,
                charges: updateObjectInArray(state.charges, response.data, action.id)
            };
        case types.DELETE_CHARGES_SUCCESS:
            return {
                ...state,
                charges : state.charges.filter( (item, index) => index !== action.id)
            };

        case types.DELETE_CHARGES_ERROR:
            return {
                ...state,
                error:  response.error
            };
       
        default:
            return state;
    }
};
