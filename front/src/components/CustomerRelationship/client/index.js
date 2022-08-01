import React, {Component} from 'react';
import {connect} from "react-redux";

import {getCookie} from "../../../utils/cookies";
import CrudTableComponent from "./CrudTableComponent";
import {getClientsAction} from "../../../actions/clientActions";


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
            this.props.getClientsAction(token);
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
    getClientsAction,
};


function mapStateToProps(state) {
    return {
        token: state.login.token,
        clients: state.clients.clients,
    };
}

export default connect(mapStateToProps, mapDispatchToProps)(Permissions);
