import * as types from "../../actions";
import { updateObjectInArray} from "../../utils";

export default function (state = {
    error: '',
    employees: []
}, action) {
    const response = action.response;

    switch (action.type) {
        case types.GET_EMPLOYEES_SUCCESS:
            return {...state, employees: response.data};
        case types.GET_EMPLOYEES_ERROR:
            return {
                ...state,
                response
            };
        case types.ADD_CLIENT_SUCCESS:
            return {
                ...state,
                employees: state.employees.concat(response.data)
            };
        case types.ADD_CLIENT_ERROR:
            return {
                ...state,
                response
            };
        case types.UPDATE_CLIENT_SUCCESS:
            return {
                ...state,
                employees: updateObjectInArray(state.employees, response.data, action.id)

            };
        case types.DELETE_CLIENT_SUCCESS:
            return {
                ...state,
                employees : state.employees.filter( (item, index) => index !== action.id)
            };

        case types.ADD_MULTIPLE_CLIENT_SUCCESS:
            return {
                ...state,
                employees: state.employees.concat(response.data)
            };
        case types.ADD_MULTIPLE_CLIENT_ERROR:
            return {
                ...state,
                error: response
            };

        default:
            return state;
    }
};
