import React, {Component} from 'react';
import {connect} from "react-redux";

import {getCookie} from "../../../utils/cookies";
import CrudTableComponent from "./CrudTableComponent";
import {getFolderTechSituationsAction} from "../../../actions/folderTechActions";


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
            this.props.getFolderTechSituationsAction(token);
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
    getFolderTechSituationsAction
};


function mapStateToProps(state) {
    return {
        token: state.login.token,
        folderTechSituations: state.folderTechSituations.folderTechSituations,
    };
}

export default connect(mapStateToProps, mapDispatchToProps)(Permissions);
