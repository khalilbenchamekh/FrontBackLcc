import React from "react";
import { makeStyles } from "@material-ui/core/styles";
import Paper from "@material-ui/core/Paper";
import Grid from "@material-ui/core/Grid";
import Icon from "@material-ui/core/Icon";
import { NavLink } from "react-router-dom";
import { BackgroundImage } from "devextreme-react/range-selector";
import Separator from "../Shared/Separator";

const useStyles = makeStyles((theme) => ({
  card: {
    display: "flex",
    flexFlow: "column",
    height: "140px",
  },
  root: {
    display: "flex",
    flexFlow: "row",
    height: "100px",
    padding: "10px 10px 0px 5px",
    cursor: "pointer",
  },
  imageIcon: {
    width: "80px",
    marginRight: "10px",
    display: "flex"
  },
  image: {
    width: "80px",
    height: "80px",
    objectFit: "contain",
    border: "solid thin #777",
    padding: "5%",
    borderRadius: "140px"
  },
  Infos: {
    flexGrow: 1,
    display: "flex",
    flexFlow: "column",
  },
  InfoNameConnection: {
    display: "flex",
    flexFlow: "row",
  },
  InfoName: {
    flexGrow: 1
  },
  InfoConnection: {
    width: "10px",
    height: "10px",
    borderRadius: "10px",
  },
  InfoMail: {
    marginLeft: "7px",
    paddingTop: "10px",
  },
  InfoActions: {
    height: "40px",
    display: "flex",
    justifyContent: "flex-end",
  },
}));

export default function EmployeeCard({ name, image, profession_number, position_held, isOnline, onClick, actionsRender }) {
  const classes = useStyles();
  const handleClick = (e) => {
    onClick();
    e.preventDefault();
  }
  return (
    <Grid item xs={6} sm={4}>
      <Paper className={classes.card} elevation={3}>
        <div onClick={handleClick} className={classes.root}>
          <div className={classes.imageIcon}>
            <img
              className={classes.image}
              src={image}
            />
          </div>
          <div className={classes.Infos}>
            <div className={classes.InfoNameConnection}>
              <div className={classes.InfoName}>
                {name}
              </div>
              <div className={classes.InfoConnection} style={{ backgroundColor: isOnline ? "#090" : "#900" }} />
            </div>
            <div className={classes.InfoMail}>
              <div> <span className="text-secondary">Num:</span> {profession_number}</div>
              <div> <span className="text-secondary">Poste:</span> {position_held}</div>
            </div>
          </div>
        </div>
        <div className={classes.InfoActions}>
          {actionsRender()}
        </div>
      </Paper>
    </Grid>
  );
}
