import React, {Component} from 'react';
import {connect} from "react-redux";

import CrudTableComponent from "./CrudTableComponent";
import {getCookie} from "../../../utils/cookies";
import {getChargeNatureToSelectAction} from "../../../actions/chargeTypeActions";
import {getChargeAction} from "../../../actions/chargeActions";
import {getInvoiceStatusToSelectAction} from "../../../actions/invoiceStatusActions";



class Permissions extends Component {
    constructor(props, context) {
        super(props, context);
        this.state = {
            multiValue: [],
            multiValueSelect: [],
        };
    }

    componentDidMount() {
        let token = this.props.token === '' ? getCookie('token') : this.props.token;
        if (token) {
            this.props.getChargeNatureToSelectAction(token);
            this.props.getChargeAction(token);
            this.props.getInvoiceStatusToSelectAction(token);
        }
    }

    render() {

        return (

            <div className='container divEx1'>
           <CrudTableComponent/>
            </div>

        )
    }
}

const mapDispatchToProps = {
    getChargeNatureToSelectAction,getInvoiceStatusToSelectAction,
    getChargeAction
};


function mapStateToProps(state) {
    return {
        token: state.login.token,
    };
}

export default connect(mapStateToProps, mapDispatchToProps)(Permissions);
