import * as types from "../../actions";
import { updateObjectInArray} from "../../utils";

export default function (state = {
    error: '',
    loadNatures: []
}, action) {
    const response = action.response;

    switch (action.type) {
        case types.GET_LOAD_NATURES_SUCCESS:
            return {...state, loadNatures: response.data};
        case types.GET_LOAD_NATURES_ERROR:
            return {
                ...state,
                response
            };
        case types.ADD_LOAD_NATURES_SUCCESS:
            return {
                ...state,
                loadNatures: state.loadNatures.concat(response.data)
            };
        case types.ADD_LOAD_NATURES_ERROR:
            return {
                ...state,
                response
            };
        case types.UPDATE_LOAD_NATURES_SUCCESS:
            return {
                ...state,
                loadNatures: updateObjectInArray(state.loadNatures, response.data, action.id)

            };
        case types.DELETE_LOAD_NATURES_SUCCESS:

            return {
                ...state,
                loadNatures : state.loadNatures.filter( (item, index) => index !== action.id)
            };

        case types.ADD_MULTIPLE_LOAD_NATURES_SUCCESS:
            return {
                ...state,
                loadNatures: state.loadNatures.concat(response.data)
            };
        case types.ADD_MULTIPLE_LOAD_NATURES_ERROR:
            return {
                ...state,
                error: response
            };

        default:
            return state;
    }
};
