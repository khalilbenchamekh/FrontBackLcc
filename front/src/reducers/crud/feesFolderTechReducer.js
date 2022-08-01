import * as types from "../../actions";
import { updateObjectInArray} from "../../utils";
export default function (state = {
    error: '',
    feesFolder: [],
}, action) {
    const response = action.response;
    switch (action.type) {
        case types.GET_FOLDER_TECH_FEES_SUCCESS:
            return {...state, feesFolder: response.data};
        case types.GET_FOLDER_TECH_FEES_ERROR:
            return {
                ...state,
                error:  response.error
            };
        case types.ADD_FOLDER_TECH_FEES_SUCCESS:
            return {
                ...state,
                feesFolder: state.feesFolder.concat(response.data)
            };
        case types.ADD_FOLDER_TECH_FEES_ERROR:
            return {
                ...state,
                error:  response.error

            };
        case types.UPDATE_FOLDER_TECH_FEES_SUCCESS:
            return {
                ...state,
                feesFolder: updateObjectInArray(state.feesFolder, response.data, action.id)
            };
        default:
            return state;
    }
};
