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
        height: '100%',
        "&:hover": {
            backgroundColor: "#00000011",
        }
    },
    avatar: {
        alignSelf: "center"
    },
    message: {
        alignSelf: "center",
        flexGrow: 1,
        paddingLeft: 20
    }
};

const FriendCard = ({ classes, name, avatar, onClick }) => {
    return (
        <div className={classes.root} onClick={onClick}>
            <div className={classes.avatar}>
                <Avatar
                    alt={name}
                    src={avatar || "https://material-ui.com/static/images/avatar/2.jpg"}
                />
            </div>
            <div className={classes.message}>
                <div className="font-weight-bold">{name}</div>
            </div>
        </div>
    )
}

export default withStyles(styles)(FriendCard);