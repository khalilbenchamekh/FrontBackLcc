import React, { Component } from "react";
import NavBar from "./menu/NavBar";
class AdminDashboard extends Component {
  render() {
    return (
      <div className="container-lg">
        <NavBar />
        {this.props.children}
      </div>
    );
  }
}

export default AdminDashboard;
