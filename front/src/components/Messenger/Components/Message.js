import React, { Component } from 'react';
import PropTypes from 'prop-types';
import { withStyles } from '@material-ui/styles';
import { Avatar } from '@material-ui/core';

const styles = {
  root: {
    display: "flex",
    flexDirection: "row",
    justifyContent: "center",
    padding: "4px 5px",
    flexBasis: "30vh",
    cursor: "pointer",
    "&:hover": {
      backgroundColor: "#00000011",
    }
  },
  avatar: {
    flexBasis: "10%",
    alignSelf: "center"
  },
  message: {
    flexGrow: 1,
    paddingLeft: 10
  }
};

const Message = ({ classes, name, message, avatar, selected, onSelect }) => {
  return (
    <div
      onClick={() => onSelect({ name, avatar })}
      className={classes.root}
      style={selected ? { backgroundColor: "#ffffff55" } : {}}
    >
      <div className={classes.avatar}>
        <Avatar
          alt={name}
          src={avatar || "https://material-ui.com/static/images/avatar/2.jpg"}
        />
      </div>
      <div className={classes.message}>
        <div className="font-weight-bold">{name}</div>
        <div className="text-dark"> {message}</div>
      </div>
    </div>
  )
}

export default withStyles(styles)(Message);