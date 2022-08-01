import * as types from "../../actions";
import { updateObjectInArray} from "../../utils";

export default function (state = {
    error: '',
    folderTech: []
}, action) {
    const response = action.response;

    switch (action.type) {
        case types.GET_FOLDERTECH_SUCCESS:
            return {...state, folderTech: response.data};
        case types.GET_FOLDERTECH_ERROR:
            return {
                ...state,
                response
            };
        case types.ADD_FOLDERTECH_SUCCESS:
            return {
                ...state,
                folderTech: state.folderTech.concat(response.data)
            };
        case types.ADD_FOLDERTECH_ERROR:
            return {
                ...state,
                response
            };
        case types.UUPDATE_FOLDERTECH_SUCCESS:
            return {
                ...state,
                folderTech: updateObjectInArray(state.folderTech, response.data, action.id)

            };
        case types.DELETE_FOLDERTECH_SUCCESS:

            // let newState = [...state];
            // newState.splice(action.index, 1);
            // return newState;
            return {
                ...state,
                folderTech : state.folderTech.filter( (item, index) => index !== action.id)
            };

        default:
            return state;
    }
};
