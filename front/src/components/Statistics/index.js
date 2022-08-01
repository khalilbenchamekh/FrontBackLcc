import React, { Component } from "react";
import { compose } from "recompose";
import { withStyles } from "@material-ui/styles";
import { connect } from "react-redux";
import StatisticsFilter from "./components/StatisticsFilter";
import StatisticResults from "./components/StatisticResults";
import RapportTable from "./components/RapportTable";

const styles = {
  root: {
    position: 'relative',
    display: 'flex',
    flexDirection: "column",
    width: '100%',
    height: '100%',
  },
  filter: {
  },
};
class Statistics extends Component {

  render() {
    const { rapportSelected } = this.props;

    return (
      <div style={styles.root}>
        <div style={styles.filter}>
          <StatisticsFilter />
        </div>
        {
          rapportSelected
            ? (
              <div style={styles.filter}>
                <RapportTable />
              </div>
            )
            : (
              <div style={styles.filter}>
                <StatisticResults />
              </div>
            )
        }
      </div>
    );
  }
}
function mapStateToProps(state) {
  return {
    rapportSelected: state.statistics.rapportSelected,
  };
}
export default compose(
  withStyles(styles),
  connect(mapStateToProps, null),
)(Statistics);

