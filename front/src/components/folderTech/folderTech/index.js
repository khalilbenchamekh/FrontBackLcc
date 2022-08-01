import React, { Component } from "react";
import { connect } from "react-redux";

import { getCookie } from "../../../utils/cookies";
import CrudTableComponent from "./CrudTableComponent";
import { getClientsAction } from "../../../actions/clientActions";
import {getFolderTechAction, getFolderTechNaturesAction} from "../../../actions/folderTechActions";
import {
  getClientByIdAction,
  getFolderNaturesByNameAction,
  getFolderSituationByIdAction,
  getIntermediatesByIdAction, getLoadRelatedToAction
} from "../../../actions/selectActions";

class Permissions extends Component {
  componentDidMount() {
    let token = this.props.token === "" ? getCookie("token") : this.props.token;
    if (token) {
      this.props.getFolderTechAction(token);
      this.props.getFolderSituationByIdAction(token);
      this.props.getFolderNaturesByNameAction(token);
      this.props.getLoadRelatedToAction(token);
      this.props.getClientByIdAction(token);
      this.props.getIntermediatesByIdAction(token);
    }
  }
  render() {
    return (
      <div className="container divEx1">
        <CrudTableComponent />
      </div>
    );
  }
}

const mapDispatchToProps = {
  getLoadRelatedToAction,getClientByIdAction,getIntermediatesByIdAction,
  getFolderTechAction,getFolderSituationByIdAction,getFolderNaturesByNameAction
};

function mapStateToProps(state) {
  return {
    token: state.login.token
  };
}

export default connect(mapStateToProps, mapDispatchToProps)(Permissions);
