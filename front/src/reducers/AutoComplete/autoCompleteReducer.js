import * as types from "../../actions";
import {convertIdToStringFromArray} from "../../utils";

export default function (state = {
    error: '',
    openAutoComplete:false,
    suggestions: [ {
        "value": "",
        "id": ""
    }]
}, action) {
    const response = action.response;

    switch (action.type) {

        case types.GET_AUTOCOMPLETE_ERROR:
            return {
                ...state,
                error: response
            };
            case types.SET_AUTOCOMPLETE_OPEN_TO_TRUE:
            return {
                ...state,
                openAutoComplete: true
            };
            case types.SET_AUTOCOMPLETE_OPEN_TO_FALSE:
            return {
                ...state,
                openAutoComplete: false
            };
        case types.GET_AUTOCOMPLETE_SUCCESS:
            return {
                ...state,
                suggestions: convertIdToStringFromArray(response)
            };
        default:
            return state;
    }
};
