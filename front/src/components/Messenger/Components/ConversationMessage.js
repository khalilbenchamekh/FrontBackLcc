import React, { Component } from 'react';
import PropTypes from 'prop-types';
import { withStyles } from '@material-ui/styles';
import { Avatar } from '@material-ui/core';
import Separator from '../../Shared/Separator';
import { AttachFile } from '@material-ui/icons';

const styles = {
    root: {
        display: "flex",
        flexDirection: "row",
        justifyContent: "center",
        padding: "12px 5px 6px 5px",
        cursor: "pointer",
        "&:hover": {
            backgroundColor: "#00000011",
        },
        width: "100%"
    },
    avatar: {
        flexBasis: "50px",
        alignSelf: "start"
    },
    message: {
        flexGrow: 1,
        paddingLeft: 4
    },
    list: {
        listStyle: "none",
        paddingLeft: 0,
    }
};

const ConversationMessage = ({ classes, messages, avatar, name }) => {
    return (
        <div className={classes.root}>
            <div className={classes.avatar}>
                <Avatar
                    alt={name}
                    src={avatar || "https://material-ui.com/static/images/avatar/2.jpg"}
                />
            </div>
            <div className={classes.message}>
                <div className="font-weight-bold">{name}</div>
                <div className="text-secondary">
                    <ul className={classes.list}>
                        {
                            messages && messages.map((msg, index) => {
                                if (msg.type === "file") {
                                    return (
                                        <li key={name + "-" + index}><a target="_blanc" href={msg.link}><AttachFile />{msg.content}</a></li>
                                    )
                                }
                                return (
                                    <li key={name + "-" + index}>{msg.content}</li>
                                )
                            })
                        }
                    </ul>
                </div>
            </div>
        </div>
    )
}

export default withStyles(styles)(ConversationMessage);