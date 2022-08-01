import React, {Component} from 'react';
import {connect} from "react-redux";

import CrudTableComponent from "./CrudTableComponent";
import {getCookie} from "../../utils/cookies";
import {getCadastraleConsultationAction} from "../../actions/CadastralconsultationActions";



class Permissions extends Component {
    componentDidMount() {
        let token = this.props.token === '' ? getCookie('token') : this.props.token;
        if (token) {
            this.props.getCadastraleConsultationAction(token);
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
    getCadastraleConsultationAction,
};


function mapStateToProps(state) {
    return {
        token: state.login.token,
    };
}

export default connect(mapStateToProps, mapDispatchToProps)(Permissions);
