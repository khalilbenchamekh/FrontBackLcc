import React from "react";
import { makeStyles } from "@material-ui/core/styles";
import Paper from "@material-ui/core/Paper";
import Grid from "@material-ui/core/Grid";
import Icon from "@material-ui/core/Icon";
import { NavLink } from "react-router-dom";

const useStyles = makeStyles((theme) => ({
  root: {
    display: "flex",
    alignItems: "center",
    height: 100,
    paddingTop: "0 !important",
    fontSize: "50vi",
    fontWeight: "bold",
    color: "#333",
  },
  icon: {
    display: "flex",
    alignItems: "center",
    height: 100,
    paddingTop: "0 !important",
    color: "rgb(0, 132, 137) !important",
  },
  paper: {
    padding: theme.spacing(2),
    textAlign: "center",
    color: theme.palette.text.secondary,
    height: 100,
    cursor: "pointer",
  },
  link: {
    textDecoration: "none !important"
  },
}));

export default function FullWidthGrid({ icon, url, label }) {
  const classes = useStyles();

  return (
    <Grid item xs={6} sm={3}>
      <Paper className={classes.paper} elevation={3}>
        <NavLink className={classes.link} to={url || "#"}>
          <Grid container spacing={3}>
            <Grid className={classes.icon} item xs={6} sm={3}>
              <Icon className={`fa ${icon}`} color="primary" />
            </Grid>
            <Grid className={classes.root} item xs={6} sm={9}>
              {label}
            </Grid>
          </Grid>
        </NavLink>
      </Paper>
    </Grid>
  );
}
