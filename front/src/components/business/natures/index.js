import React, {Component} from 'react';
import {connect} from "react-redux";

import {getCookie} from "../../../utils/cookies";
import {getBusinessNaturesAction} from "../../../actions/businessActions";
import CrudTableComponent from "./CrudTableComponent";
let columns = [
    {
        name: "Name",
        options: {
            filter: true,
        }
    }
    ,
    {
        name: "Abr_v",
        options: {
            filter: true,
        }
    },

];

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
            this.props.getBusinessNaturesAction(token);
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
    getBusinessNaturesAction
};


function mapStateToProps(state) {
    return {
        token: state.login.token,
        businessNatures: state.businessNatures.businessNatures,
    };
}

export default connect(mapStateToProps, mapDispatchToProps)(Permissions);
