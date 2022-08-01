import * as types from "../../actions";
import { updateObjectInArray } from "../../utils";

export default function (state = {
    error: '',
    folderTechNatures: []
}, action) {
    const response = action.response;

    switch (action.type) {
        case types.GET_FOLDERTECH_NATURES_SUCCESS:
            return { ...state, folderTechNatures: response.data };
        case types.GET_FOLDERTECH_NATURES_ERROR:
            return {
                ...state,
                response
            };
        case types.ADD_FOLDERTECH_NATURES_SUCCESS:
            return {
                ...state,
                folderTechNatures: state.folderTechNatures.concat(response.data)
                // folderTechNatures: {...state.folderTechNatures.push(...response.data) }
            };
        case types.ADD_FOLDERTECH_NATURES_ERROR:
            return {
                ...state,
                response
            };
        case types.UPDATE_FOLDERTECH_NATURES_SUCCESS:
            return {
                ...state,
                folderTechNatures: updateObjectInArray(state.folderTechNatures, response.data, action.id)

            };
        case types.DELETE_FOLDERTECH_NATURES_SUCCESS:

            // let newState = [...state];
            // newState.splice(action.index, 1);
            // return newState;
            return {
                ...state,
                folderTechNatures: state.folderTechNatures.filter((item, index) => index !== action.id)
            };

        case types.ADD_MULTIPLE_FOLDERTECH_NATURES_SUCCESS:
            return {
                ...state,
                folderTechNatures: state.folderTechNatures.concat(response.data)
                // folderTechNatures: {...state.folderTechNatures.push(...response.data) }
            };
        case types.ADD_MULTIPLE_FOLDERTECH_NATURES_ERROR:
            return {
                ...state,
                error: response
            };
        default:
            return state;
    }
};
