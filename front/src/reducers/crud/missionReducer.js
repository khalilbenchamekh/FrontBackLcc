import * as types from "../../actions";
import { updateObjectInArray} from "../../utils";

export default function (state = {
    error: '',
    missions: []
}, action) {
    const response = action.response;

    switch (action.type) {
        case types.GET_MISSIONS_SUCCESS:
            return {...state, missions: response.data};
        case types.GET_MISSIONS_ERROR:
            return {
                ...state,
                missions:   response.data
            };
        case types.ADD_MISSIONS_SUCCESS:
            return {
                ...state,
                missions: state.missions.concat(response.data)
            };
        case types.ADD_MISSIONS_ERROR:
            return {
                ...state,
                response
            };
        case types.UPDATE_MISSIONS_SUCCESS:
            return {
                ...state,
                missions: updateObjectInArray(state.missions, response.data, action.id)

            };
        case types.DELETE_MISSIONS_SUCCESS:
            return {
                ...state,
                missions : state.missions.filter( (item, index) => index !== action.id)
            };

        default:
            return state;
    }
};
