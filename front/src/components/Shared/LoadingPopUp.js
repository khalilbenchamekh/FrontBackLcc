import React, { Component } from "react";
import { connect } from "react-redux";
import Paper from "@material-ui/core/Paper";
import Grid from "@material-ui/core/Grid";
import { compose } from "recompose";
import { withStyles } from "@material-ui/styles";
import Autocomplete from "@material-ui/lab/Autocomplete";
import DeleteForeverIcon from "@material-ui/icons/DeleteForever";
import { CircularProgress } from "@material-ui/core";
import PropTypes from "prop-types";

const style = {
  root: {
    display: "flex",
    alignItems: "center",
    justifyContent: "center",
    position: "absolute",
    top: "-10px",
    left: "0px",
    bottom: "0px",
    right: "0px",
    backgroundColor: "#00000066",
    zIndex: 1000000,
    userSelect: "none",
  },
  progress: {
    color: "#7CFC00",
  },
};

const LoadingPopUp = ({ classes, loading }) => {
  return loading ? (
    <div className={classes.root}>
      <CircularProgress
        variant="indeterminate"
        size={50}
        thickness={4}
        className={classes.progress}
      />
    </div>
  ) : (
      <></>
    );
};
LoadingPopUp.propTypes = {
  classes: PropTypes.object,
  show: PropTypes.bool,
};
LoadingPopUp.defaultProps = {
  classes: {},
  show: false,
};

const mapDispatchToProps = {
  show: false,
};

function mapStateToProps(state) {
  return { ...state.spinner };
}

export default compose(
  withStyles(style, {
    name: "loader",
  }),
  connect(mapStateToProps, mapDispatchToProps)
)(LoadingPopUp);
