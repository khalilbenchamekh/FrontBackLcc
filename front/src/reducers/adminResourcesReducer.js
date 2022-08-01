import * as types from '../actions';
import {makeOptionForChart} from "../utils/dashboard/makeSatistics";
import {selectHelper} from "../utils/select/selectHelper";
import {i_need_name} from "../Constansts/selectHelper";

export default function (state = {
    routes:{
        label:'',
        value:'',
    },
    uerPer:[],
    statistics:[],
    route_name:undefined,
}, action) {
    const response = action.response;

    switch (action.type) {
        case types.GET_ROUTE_TO_PROTECT_SUCCESS:

            return {...state,  routes:
                selectHelper(response,i_need_name)
                };
        case types.GET_ROUTE_TO_PROTECT_ERROR:
            return {...state,
               response
                };

        case types.GET_USER_WITH_PERMISSION_SUCCESS:
            return {...state,
                uerPer:response
                };

            case types.HANDL_MULTI_CHANGE:
            return {...state,
                route_name:action.route_name
                };
        case types.GET_USER_WITH_PERMISSION_ERROR:
            return {...state, response};
        case types.GET_STATISTIQUES_TO_ADMIN_SUCCESS:
            return {
                ...state,
                statistics: makeOptionForChart(response.data)
            };
        default:
            return state;
    }
};
