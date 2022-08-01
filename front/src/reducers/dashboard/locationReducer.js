import {city, latitude, locations, longitude, mapboxZoom} from "../../Constansts/map";
import * as types from '../../actions';
export default function (state = {
    adr: {longitude: longitude, latitude: latitude, city: city, zoom: mapboxZoom},
    locations: locations, error: ''
}, action) {
    const response = action.response;
    switch (action.type) {
        case types.SET_POSITION:
            return {
                ...state,
                adr: action.adr
            };
        case types.GET_LOCATIONS_SUCCESS:
            return {
                ...state,
                locations: response.locations
            };
            case types.GET_LOCATIONS_ERROR:
            return {
                ...state,
                error: response
            };
        default:
            return state;
    }

}
