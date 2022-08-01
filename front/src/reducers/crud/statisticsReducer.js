import * as types from "../../actions";

export default function (state = {
    error: '',
    rapportSelected: false,
    loading: false,
    selected: {},
    content: undefined
}, action) {
    switch (action.type) {
        case types.SET_STATISTICS_LOADING:
            return {
                ...state,
                loading: action.payload
            };
        case types.SET_STATISTICS_SELECTED:
            return {
                ...state,
                selected: action.payload
            };
        case types.SET_STATISTICS_RAPPORT_SELECTED:
            return {
                ...state,
                rapportSelected: action.payload
            };
        case types.SET_STATISTICS_ERROR:
            return { ...state, error: action.payload };
        case types.SET_STATISTICS:
            return { ...state, content: formatData(action.payload.data.series) };
        default:
            return state;
    }
};


const formatData = (data) => {
    const noFees = data[0]["no-fees"];
    const fees = data[1]["fees"]
    const affairesFees = fees[0]['affaires'];
    const foldertechesFees = fees[1]['folderteches'];
    const g_c_sFees = fees[2]['g_c_s'];
    const affairesNoFees = noFees[0]['affaires'];
    const foldertechesNoFees = noFees[2]['folderteches'];
    const g_c_sNoFees = noFees[1]['sites'];
    return {
        not_paid: {
            affaires: affairesFees.factures_impayées,
            folderTech: foldertechesFees.factures_impayées,
            greatConst: g_c_sFees.factures_impayées,
            count: affairesFees.factures_impayées.length + foldertechesFees.factures_impayées.length + g_c_sFees.factures_impayées.length,
        },
        paid: {
            affaires: affairesFees.factures_payées,
            folderTech: foldertechesFees.factures_payées,
            greatConst: g_c_sFees.factures_payées,
            count: affairesFees.factures_payées.length + foldertechesFees.factures_payées.length + g_c_sFees.factures_payées.length,
        },
        not_livered: {
            affaires: affairesFees.projet_non_livré,
            folderTech: foldertechesFees.projet_non_livré,
            greatConst: g_c_sFees.projet_non_livré,
            count: affairesFees.projet_non_livré.length + foldertechesFees.projet_non_livré.length + g_c_sFees.projet_non_livré.length,
        },
        inProgress: {
            affaires: affairesNoFees.inProgress,
            folderTech: foldertechesNoFees.inProgress,
            greatConst: g_c_sNoFees.inProgress,
            count: affairesNoFees.inProgress.length + foldertechesNoFees.inProgress.length + g_c_sNoFees.inProgress.length,
        },
        notInProgress: {
            affaires: affairesNoFees.notInProgress,
            folderTech: foldertechesNoFees.notInProgress,
            greatConst: g_c_sNoFees.notInProgress,
            count: affairesNoFees.notInProgress.length + foldertechesNoFees.notInProgress.length + g_c_sNoFees.notInProgress.length,
        }
    }
}
