import * as types from "../../actions";
import { updateObjectInArray } from "../../utils";

export default function (state = {
    error: '',
    businessNatures: []
}, action) {
    const response = action.response;

    switch (action.type) {
        case types.GET_BUSINESS_NATURES_SUCCESS:
            return { ...state, businessNatures: response.data };
        case types.GET_BUSINESS_NATURES_ERROR:
            return {
                ...state,
                response
            };
        case types.ADD_BUSINESS_NATURES_SUCCESS:
            return {
                ...state,
                businessNatures: state.businessNatures.concat(response.data)
                // businessNatures: {...state.businessNatures.push(...response.data) }
            };
        case types.ADD_BUSINESS_NATURES_ERROR:
            return {
                ...state,
                response
            };
        case types.UPDATE_BUSINESS_NATURES_SUCCESS:
            return {
                ...state,
                businessNatures: updateObjectInArray(state.businessNatures, response.data, action.id)

            };
        case types.DELETE_BUSINESS_NATURES_SUCCESS:

            // let newState = [...state];
            // newState.splice(action.index, 1);
            // return newState;
            return {
                ...state,
                businessNatures: state.businessNatures.filter((item, index) => index !== action.id)
            };

        case types.ADD_MULTIPLE_BUSINESS_NATURES_SUCCESS:
            return {
                ...state,
                businessNatures: state.businessNatures.concat(response.data)
                // businessNatures: {...state.businessNatures.push(...response.data) }
            };
        case types.ADD_MULTIPLE_BUSINESS_NATURES_ERROR:
            return {
                ...state,
                error: response
            };
        default:
            return state;
    }
};
