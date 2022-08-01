import React, { Component } from "react";
import NavBar from "../menu/NavBar";
import { connect } from "react-redux";
import { checkForTokenAction } from "../../actions/authenticationActions";

class AdminDashboard extends Component {
  componentDidMount() {
  }

  render() {
    return (
      <div className="container-lg">
        <NavBar />
      </div>
    );
  }
}
const mapDispatchToProps = {
  checkForTokenAction,
};

function mapStateToProps(state) {
  return {
    token: state,
  };
}
export default connect(mapStateToProps, mapDispatchToProps)(AdminDashboard);
