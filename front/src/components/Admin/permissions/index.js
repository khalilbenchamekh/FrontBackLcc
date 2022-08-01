
import React, { Component } from 'react';
import { connect } from "react-redux";
import { getRouteToProtectAction, getUsersWithPermissionsAction } from "../../../actions/adminActions";
import { getCookie } from "../../../utils/cookies";


import Select from "react-select";
import CrudTableComponent from "./CrudTableComponent";

class Permissions extends Component {
  constructor(props, context) {
    super(props, context);
    this.state = {
      multiValue: [],
      multiValueSelect: []
    };
    this.handleMultiChange = this.handleMultiChange.bind(this);
  }

  componentDidMount() {
    let token = this.props.token === "" ? getCookie("token") : this.props.token;
    if (token) {
      this.props.getRouteToProtectAction(token);
    }
  }


  handleMultiChange(option) {
    let token = this.props.token === '' ? getCookie('token') : this.props.token;
    if (token) {
      if (option.value) {
        this.props.getUsersWithPermissionsAction(token, option.value);
      }
    }

    this.setState({
      multiValue: option
    });

  }

  componentWillReceiveProps(nextProps, nextContext) {
    if (nextProps.routes !== this.props.routes) {
      this.setState({
        multiValueSelect: nextProps.routes
      })
    }
  }

  render() {
    const { userPer } = this.props;
    const { multiValue, multiValueSelect } = this.state;
    return (

      <div className='container divEx1'>
        <div className='row'>
          <div className='col col-12 table-index'>
            <Select
              name="filters"
              placeholder="Filters"
              value={multiValue}
              options={multiValueSelect}
              onChange={this.handleMultiChange}
            />
          </div>

        </div>


        <div className='row'>
          <div className="col col-12 ">
            <CrudTableComponent />
          </div>

        </div>
      </div>
    )

  }
}





const mapDispatchToProps = {
  getRouteToProtectAction,
  getUsersWithPermissionsAction
};

function mapStateToProps(state) {
  return {
    routes: state.adminRes.routes,
    userPer: state.adminRes.uerPer,
    token: state.login.token
  };
}

export default connect(mapStateToProps, mapDispatchToProps)(Permissions);
