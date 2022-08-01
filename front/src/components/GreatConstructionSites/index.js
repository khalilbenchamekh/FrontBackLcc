import React, { Component } from 'react';
import { connect } from "react-redux";

import CrudTableComponent from "./CrudTableComponent";
import { getCookie } from "../../utils/cookies";
import {
    getGreatConstructionSitesAction,
    getSatitstiquesGreatConstructionSitesAction
} from "../../actions/greatConstructionSiteActions";
import { getAllocatedBrigadesAction, getLoadRelatedToAction, getLocationAction } from "../../actions/selectActions";


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
            this.props.getAllocatedBrigadesAction(token);
            this.props.getLocationAction(token);
            this.props.getLoadRelatedToAction(token);
            this.props.getGreatConstructionSitesAction(token);
            this.props.getSatitstiquesGreatConstructionSitesAction(token);
        }
    }


    render() {

        return (

            <div className='container divEx1'>
                <CrudTableComponent />
            </div>

        )
    }
}

const mapDispatchToProps = {
    getGreatConstructionSitesAction, getSatitstiquesGreatConstructionSitesAction,
    getLoadRelatedToAction, getLocationAction, getAllocatedBrigadesAction
};


function mapStateToProps(state) {
    return {
        token: state.login.token,
    };
}

export default connect(mapStateToProps, mapDispatchToProps)(Permissions);
