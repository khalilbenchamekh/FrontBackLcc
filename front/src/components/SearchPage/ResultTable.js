import React, { Component } from "react";
import MUIDataTable from "mui-datatables";
import { connect } from "react-redux";
import PropTypes from 'prop-types';

import { createMuiTheme, MuiThemeProvider } from "@material-ui/core";
import { compose } from "recompose";
import { withStyles } from "@material-ui/styles";
const style = {
  table: {
    padding: 10
  }
};
class ResultTable extends Component {
  static propTypes = {
    user: PropTypes.object.isRequired,
    id: PropTypes.number.isRequired,
  };

  constructor(props) {
    super(props);
    this.state = {

    };

  }
  render() {
    const options = {
      filterType: "dropdown",
      responsive: "stacked",
    };
    const { classes, columns ,data} = this.props;
    const theme = createMuiTheme({
      palette: { type: "light" }
    });
    return (
      <div className="">
        <div className="col col-12 ">
            <MUIDataTable
              className={classes.table}
              title={"Recherche"}
              data={data}
              columns={columns}
              options={options}
            />
        </div>
      </div>
    );
  }
}

const mapDispatchToProps = {};

function mapStateToProps(state) {
  return {
    business: state.business.business
  };
}
export default compose(
  withStyles(style, {
    name: "CustomResultTable"
  }),
  connect(mapStateToProps, mapDispatchToProps)
)(ResultTable);
