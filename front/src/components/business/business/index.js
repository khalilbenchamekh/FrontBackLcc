import React, {Component} from 'react';
import {connect} from "react-redux";

import {getCookie} from "../../../utils/cookies";
import CrudTableComponent from "./CrudTableComponent";
import {getBusinessAction} from "../../../actions/businessActions";
import {
    getBusinessNaturesByIdAction, getBusinessSituationByIdAction,
    getClientByIdAction, getIntermediatesByIdAction,
    getLoadRelatedToAction
} from "../../../actions/selectActions";


class Permissions extends Component {
    componentDidMount() {
        let token = this.props.token === '' ? getCookie('token') : this.props.token;
        if (token) {
            this.props.getBusinessAction(token);
            this.props.getLoadRelatedToAction(token);
            this.props.getClientByIdAction(token);
            this.props.getIntermediatesByIdAction(token);
            this.props.getBusinessNaturesByIdAction(token);
            this.props.getBusinessSituationByIdAction(token);
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
    getBusinessAction,getLoadRelatedToAction,getClientByIdAction,getBusinessNaturesByIdAction,getBusinessSituationByIdAction,
    getIntermediatesByIdAction
};


function mapStateToProps(state) {
    return {
        token: state.login.token,
    };
}

export default connect(mapStateToProps, mapDispatchToProps)(Permissions);
