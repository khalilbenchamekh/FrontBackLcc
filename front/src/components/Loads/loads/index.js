import React, {Component} from 'react';
import {connect} from "react-redux";

import CrudTableComponent from "./CrudTableComponent";
import {getCookie} from "../../../utils/cookies";

import {getLoadAction, getSatitstiquesLoadAction} from "../../../actions/loadsActions";
import {getLoadRelatedToAction, getLoadTypeAction} from "../../../actions/selectActions";


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
            this.props.getLoadAction(token);
            this.props.getSatitstiquesLoadAction(token);
            this.props.getLoadTypeAction(token);
            this.props.getLoadRelatedToAction(token);
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
    getLoadAction,getSatitstiquesLoadAction,
        getLoadTypeAction,getLoadRelatedToAction
};


function mapStateToProps(state) {
    return {
        token: state.login.token,
    };
}

export default connect(mapStateToProps, mapDispatchToProps)(Permissions);
