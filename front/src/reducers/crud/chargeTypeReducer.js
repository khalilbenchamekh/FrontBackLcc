import * as types from "../../actions";
import { updateObjectInArray} from "../../utils";
import {makeOptionForChart} from "../../utils/greatConstructionSiteActions/Satistics";

export default function (state = {
    error: '',
    chargeType:{},
    chargeTypes: [],
}, action) {
    const response = action.response;
    switch (action.type) {
        case types.GET_CHARGES_NATURES_SUCCESS:
            return {...state, chargeTypes: response.data};
        case types.GET_CHARGES_NATURES_ERROR:
            return {
                ...state,
                error:  response.error
            };
        case types.ADD_CHARGES_NATURES_SUCCESS:
            return {
                ...state,
                chargeTypes: state.chargeTypes.concat(response.data)
            };
        case types.ADD_CHARGES_NATURES_ERROR:
            return {
                ...state,
                error:  response.error

            };
        case types.UPDATE_CHARGES_NATURES_SUCCESS:
            return {
                ...state,
                chargeTypes: updateObjectInArray(state.chargeTypes, response.data, action.id)
            };
        case types.DELETE_CHARGES_NATURES_SUCCESS:
            return {
                ...state,
                chargeTypes : state.chargeTypes.filter( (item, index) => index !== action.id)
            };

        case types.DELETE_CHARGES_NATURES_ERROR:
            return {
                ...state,
                error:  response.error
            };

        default:
            return state;
    }
};
