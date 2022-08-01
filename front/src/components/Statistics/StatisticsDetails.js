import React, { Component } from "react";
import { compose } from "recompose";
import { withStyles } from "@material-ui/styles";
import { connect } from "react-redux";
import StatisticsEntitiesViewer from "./components/StatisticsEntitiesViewer";
import { Grid } from "@material-ui/core";

const styles = {
  root: {
    position: 'relative',
    display: 'flex',
    flexDirection: "row",
    width: '100%',
    height: '100%',
  }
};
class StatisticsDetails extends Component {

  render() {
    const { rapportSelected } = this.props;
    console.log(rapportSelected)
    const { affaires, folderTech, greatConst } = rapportSelected;
    return (
      <Grid container spacing={3}>
        <StatisticsEntitiesViewer
          title="Dossiers techniques"
          list={folderTech}
        />
        <StatisticsEntitiesViewer
          title="Affaires"
          list={affaires}
        />
        <StatisticsEntitiesViewer
          title="Grande Chantier"
          list={greatConst}
        />
      </Grid>
    );
  }
}
function mapStateToProps(state) {
  return {
    rapportSelected: state.statistics.rapportSelected
  };
}
export default compose(
  withStyles(styles),
  connect(mapStateToProps, null),
)(StatisticsDetails);

