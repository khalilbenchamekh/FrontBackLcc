import * as types from "../../actions";

const initialStore={
    date:{first:'',second:'',firstIso:'',secondIso:''}
};
export default function  (state =initialStore, action) {
    switch (action.type) {
        case types.Add_Date:
            return {
                ...state,
                date:action.date
            };

        default:
            return state;
    }

}
