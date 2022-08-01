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
        borderBottom: "solid #00000022 thin",
        flexGrow: 1
    },
    avatar: {
        alignSelf: "center"
    },
    message: {
        flexGrow: 1,
        paddingLeft: 10,
        fontWeight: "700!important",
        alignSelf: "center"
    }
};

const ConversationTitle = ({ classes, name, avatar }) => {
    return (
        <div className={classes.root}>
            <div className={classes.avatar}>
                <Avatar
                    alt={name}
                    src={avatar}
                />
            </div>
            <div className={classes.message}>{name}</div>
        </div>
    )
}

export default withStyles(styles)(ConversationTitle);