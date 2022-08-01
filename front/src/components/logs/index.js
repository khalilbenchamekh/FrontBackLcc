import React, { Component } from "react";
import { connect } from "react-redux";

import { getCookie } from "../../utils/cookies";
import LogsList from "./LogsList";
import { getEmployeesAction } from "../../actions/employeeActions";
import { getLog } from "../../actions/logsActions";

class Logs extends Component {
  componentDidMount() {
    let token = this.props.token === "" ? getCookie("token") : this.props.token;
    if (token) {
      this.props.getLog(token);
    }
  }
  render() {
    return (
      <div className="container divEx1">
        <LogsList />
      </div>
    );
  }
}

const mapDispatchToProps = {
  getLog
};

function mapStateToProps(state) {
  return {
    token: state.login.token
  };
}

export default connect(mapStateToProps, mapDispatchToProps)(Logs);
