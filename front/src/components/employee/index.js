import React, { Component } from "react";
import { connect } from "react-redux";

import { getCookie } from "../../utils/cookies";
import CrudTableComponent from "./EmployeeList";
import { getEmployeesAction } from "../../actions/employeeActions";

class Permissions extends Component {
  componentDidMount() {
    let token = this.props.token === "" ? getCookie("token") : this.props.token;
    if (token) {
      this.props.getEmployeesAction(token);
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
  getEmployeesAction
};

function mapStateToProps(state) {
  return {
    token: state.login.token
  };
}

export default connect(mapStateToProps, mapDispatchToProps)(Permissions);
