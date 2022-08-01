import * as types from "../../actions";
import { updateObjectInArray} from "../../utils";

export default function (state = {
    error: '',
    updateModal: {
        isOpen: false,
        id: undefined
    },
    folderTechSituations: []
}, action) {
    const response = action.response;

    switch (action.type) {
        case types.GET_FOLDERTECH_SITUATIONS_SUCCESS:
            return {...state, folderTechSituations: response.data};
        case types.GET_FOLDERTECH_SITUATIONS_ERROR:
            return {
                ...state,
                response
            };
        case types.ADD_FOLDERTECH_SITUATIONS_SUCCESS:
            return {
                ...state,
                folderTechSituations: state.folderTechSituations.concat(response.data)
                // folderTechSituations: {...state.folderTechSituations.push(...response.data) }
            };
        case types.ADD_FOLDERTECH_SITUATIONS_ERROR:
            return {
                ...state,
                response
            };
        case types.UPDATE_FOLDERTECH_SITUATIONS_SUCCESS:
            return {
                ...state,
                folderTechSituations: updateObjectInArray(state.folderTechSituations, response.data, action.id)

            };
        case types.DELETE_FOLDERTECH_SITUATIONS_SUCCESS:

            // let newState = [...state];
            // newState.splice(action.index, 1);
            // return newState;
            return {
                ...state,
                folderTechSituations : state.folderTechSituations.filter( (item, index) => index !== action.id)
            };

        case types.ADD_MULTIPLE_FOLDERTECH_SITUATIONS_SUCCESS:
            return {
                ...state,
                folderTechSituations: state.folderTechSituations.concat(response.data)
            };
        case types.ADD_MULTIPLE_FOLDERTECH_SITUATIONS_ERROR:
            return {
                ...state,
                error: response
            };
    
        default:
            return state;
    }
};
