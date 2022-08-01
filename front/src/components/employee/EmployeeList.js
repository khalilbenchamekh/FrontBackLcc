import React, { Component } from "react";
import { connect } from "react-redux";
import {  Grid } from "@material-ui/core";
import { compose } from "recompose";
import { withStyles } from "@material-ui/styles";
import EmployeeCard from "../employee/EmployeeCard";
import EmployeeDetails from "./EmployeeDetails";
import FormUpdateEmployee from "./FormUpdateEmployee";
import FormAddEmployee from "./FormAddEmployee";
import {downloadEmployeeDocumentsAction} from "../../actions/employeeActions";

const style = {
  addEmployee: {
    display: "flex",
    justifyContent: "flex-end",
  }
};

class EmployeeList extends Component {
  constructor() {
    super();
    this.state = {
      details: {
        dialogOpen: false,
        employee: {}
      }
    }
  }

  handleShowDetails = (employee) => {
    this.setState({ details: { dialogOpen: true, employee: { ...employee } } });
  }
  handleHideDetails = () => {
    this.setState({ details: { dialogOpen: false, employee: {} } });
  }
  render() {
    const { details } = this.state;
    const { classes,employees } = this.props;
    return (
      <>
        <div className={classes.addEmployee}><FormAddEmployee /></div>

        <Grid container spacing={3}>
          {employees.map((item, index) => (
            <EmployeeCard
              onClick={() => this.handleShowDetails(item)}
              {...item}
              actionsRender={() => (
                <FormUpdateEmployee employee ={item} />
              )
              }
            />
          ))}
        </Grid>
        <EmployeeDetails
          open={details.dialogOpen}
          employee={details.employee}
          onClose={this.handleHideDetails}
          onUpdate={this.handleUpdateClick}
        />
      </>
    );
  }
}

const mapDispatchToProps = {
  downloadEmployeeDocumentsAction

};

function mapStateToProps(state) {
  return {
    employees: state.employees.employees
  };
}
export default compose(
  withStyles(style, {
    name: "employeeAdd"
  }),
  connect(mapStateToProps, mapDispatchToProps)
)(EmployeeList);
