import * as types from "../../actions";
import { updateObjectInArray} from "../../utils";

export default function (state = {
    error: '',
    updateModal: {
        isOpen: false,
        id: undefined
    },
    businessSituations: []
}, action) {
    const response = action.response;

    switch (action.type) {
        case types.GET_BUSINESS_SITUATIONS_SUCCESS:
            return {...state, businessSituations: response.data};
        case types.GET_BUSINESS_SITUATIONS_ERROR:
            return {
                ...state,
                response
            };
        case types.ADD_BUSINESS_SITUATIONS_SUCCESS:
            return {
                ...state,
                businessSituations: state.businessSituations.concat(response.data)
                // businessSituations: {...state.businessSituations.push(...response.data) }
            };
        case types.ADD_BUSINESS_SITUATIONS_ERROR:
            return {
                ...state,
                response
            };
        case types.UPDATE_BUSINESS_SITUATIONS_SUCCESS:
            return {
                ...state,
                businessSituations: updateObjectInArray(state.businessSituations, response.data, action.id)

            };
        case types.DELETE_BUSINESS_SITUATIONS_SUCCESS:

            // let newState = [...state];
            // newState.splice(action.index, 1);
            // return newState;
            return {
                ...state,
                businessSituations : state.businessSituations.filter( (item, index) => index !== action.id)
            };

        case types.ADD_MULTIPLE_BUSINESS_SITUATIONS_SUCCESS:
            return {
                ...state,
                businessSituations: state.businessSituations.concat(response.data)
            };
        case types.ADD_MULTIPLE_BUSINESS_SITUATIONS_ERROR:
            return {
                ...state,
                error: response
            };
    
        default:
            return state;
    }
};
