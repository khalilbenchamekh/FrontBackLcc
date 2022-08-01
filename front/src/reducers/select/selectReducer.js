import * as types from '../../actions';
import { complexHelper, selectHelper, selectIceSelect } from "../../utils/select/selectHelper";
import { i_need_id, i_need_name } from "../../Constansts/selectHelper";


export default function (state = {
    load_types: {
        label: '',
        value: '',
    },
    related_to: {
        label: '',
        value: '',
    }, BusinessBy_Id: {
        label: '',
        value: '',
    }, FolderTechBy_Id: {
        label: '',
        value: '',
    }, locationsBy_Id: {
        label: '',
        value: '',
    }, locatedBrigades: {
        label: '',
        value: '',
    }, client: {
        label: '',
        value: '',
    }, businessName: {
        label: '',
        value: '',
    }, businessSituations: {
        label: '',
        value: '',
    }, folderSituations: {
        label: '',
        value: '',
    }, FolderNaturesName: {
        label: '',
        value: '',
    }, intermediates: {
        label: '',
        value: '',
    }, employees: [
        {
            label: 'Amine Zerouali',
            value: 259,
            created_at: "2020-06-15 17:23:21",
            unread: 0,
        }, {
            label: 'Khalil Benchamekh',
            created_at: "2020-06-15 17:23:21",
            value: 128,
            unread: 0,
        }, {
            label: 'Khalil Elghabi',
            value: 217,
            created_at: "2020-06-15 17:23:21",
            unread: 0,
        },
    ],
    client_ice: {
        label: '',
        value: '',
    }, client_iD: {
        label: '',
        value: '',
    }, chargeTypesId: {
        label: '',
        value: '',
    }, invoiceStatusId: {
        label: '',
        value: '',
    },
    error: ''
}, action) {
    const response = action.response;

    switch (action.type) {
        case types.GET_LOAD_TYPES_SUCCESS:

            return {
                ...state, load_types:
                    selectHelper(response.data, i_need_name)
            };
        case types.GET_LOAD_TYPES_ERROR:
            return {
                ...state,
                error: response
            };

        case types.GET_BUSINESS_BY_ID_SUCCESS:

            return {
                ...state, BusinessBy_Id:
                    complexHelper(response.data, i_need_id, 'REF')
            };
        case types.GET_BUSINESS_BY_ID_ERROR:
            return {
                ...state,
                error: response
            };
        case types.GET_FOLDER_TECH_BY_ID_SUCCESS:

            return {
                ...state, FolderTechBy_Id: complexHelper(response.data, i_need_id, 'REF')
            };
        case types.GET_FOLDER_TECH_BY_ID_ERROR:
            return {
                ...state,
                error: response
            };
        case types.GET_LOAD_RELATED_TO_SUCCESS:
            return {
                ...state, related_to:
                    selectHelper(response.data, i_need_id)
            };
        case types.GET_LOAD_RELATED_TO_ERROR:
            return {
                ...state,
                error: response
            };
        case types.GET_LOCATION_SUCCESS:
            return {
                ...state, locationsBy_Id:
                    selectHelper(response.data, i_need_id)
            };
        case types.GET_LOCATION_ERROR:
            return {
                ...state,
                error: response
            };
        case types.GET_ALL_LOCATED_BRIGADES_SUCCESS:
            return {
                ...state, locatedBrigades:
                    selectHelper(response.data, i_need_name),
                client: selectHelper(response.data, i_need_id)
            };
        case types.GET_ALL_LOCATED_BRIGADES_ERROR:
            return {
                ...state,
                error: response
            };


        case types.GET_CLIENT_BY_ID_SUCCESS:
            return {
                ...state, client:
                    selectHelper(response.data, i_need_id)
            };
        case types.GET_CLIENT_BY_ID_ERROR:
            return {
                ...state,
                error: response
            };
        case types.GET_BUSINESS_NATURE_BY_NAME_SUCCESS:
            return {
                ...state, businessName:
                    complexHelper(response.data, i_need_name, 'Name')
            };
        case types.GET_BUSINESS_NATURE_BY_NAME_ERROR:
            return {
                ...state,
                error: response
            };

        case types.GET_FOLDER_TECH_NATURE_BY_NAME_SUCCESS:
            return {
                ...state, FolderNaturesName:
                    complexHelper(response.data, i_need_name, 'Name')
            };
        case types.GET_FOLDER_TECH_NATURE_BY_NAME_ERROR:
            return {
                ...state,
                error: response
            };
        case types.GET_BUSINESS_SITUATION_BY_ID_SUCCESS:
            return {
                ...state, businessSituations:
                    complexHelper(response.data, i_need_id, 'Name')
            };
        case types.GET_BUSINESS_SITUATION_BY_ID_ERROR:
            return {
                ...state,
                error: response
            };

        case types.GET_FOLDER_TECH_SITUATION_BY_ID_SUCCESS:
            return {
                ...state, folderSituations:
                    complexHelper(response.data, i_need_id, 'Name')
            };
        case types.GET_FOLDER_TECH_SITUATION_BY_ID_ERROR:
            return {
                ...state,
                error: response
            };
        case types.GET_INTERMEDIATES_BY_ID_SUCCESS:
            return {
                ...state, intermediates:
                    selectHelper(response.data, i_need_id)
            };
        case types.GET_INTERMEDIATES_BY_ID_ERROR:
            return {
                ...state,
                error: response
            };

        case types.GET_CHARGES_NATURES_TO_SELECT_SUCCESS:
            return {
                ...state, chargeTypesId:
                    selectHelper(response.data, i_need_id)
            };
        case types.GET_CHARGES_NATURES_TO_SELECT_ERROR:
            return {
                ...state,
                error: response
            };

        case types.GET_INVOICE_STATUS_TO_SELECT_SUCCESS:
            return {
                ...state, invoiceStatusId:
                    selectHelper(response.data, i_need_id)
            };
        case types.GET_INVOICE_STATUS_TO_SELECT_ERROR:
            return {
                ...state,
                error: response
            };
        case types.CLIENT_BILL_SELECT_SUCCESS:
            return {
                ...state,
                client_ice: selectIceSelect(response)
            };
        case types.CLIENT_BILL_SELECT_ERROR:
            return {
                ...state,
                error: response
            };


        default:
            return state;
    }
};
