import React, {Component} from 'react';
import {connect} from "react-redux";

import CrudTableComponent from "./CrudTableComponent";
import {getCookie} from "../../../utils/cookies";

import {getBusinessByIdAction, getBusinessFeesAction} from "../../../actions/feesActions";


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
            this.props.getBusinessByIdAction(token);
            this.props.getBusinessFeesAction(token);
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
    getBusinessByIdAction,
    getBusinessFeesAction
};


function mapStateToProps(state) {
    return {
        token: state.login.token,
    };
}

export default connect(mapStateToProps, mapDispatchToProps)(Permissions);
