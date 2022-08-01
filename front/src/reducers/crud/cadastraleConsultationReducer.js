import * as types from "../../actions";

export default function (state = {
    error: '',
    cadaster: []
}, action) {
    const response = action.response;

    switch (action.type) {
        case types.GET_GREAT_CADASTRAL_CONSULTATION_SUCCESS:
            return {...state, cadaster: response.data};
        case types.GET_GREAT_CADASTRAL_CONSULTATION_ERROR:
            return {
                ...state,
                error: response.error
            };
        case types.ADD_MULTIPLE_CADASTRAL_CONSULTATION_SUCCESS:
            return {
                ...state,
                cadaster: response.data
            };
        case types.ADD_MULTIPLE_CADASTRAL_CONSULTATION_ERROR:
            return {
                ...state,
                error: response.error
            };

        default:
            return state;
    }
};
