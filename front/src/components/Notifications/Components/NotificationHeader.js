import React, { Component } from 'react';
import { withStyles } from '@material-ui/core';


const style = {
    root: {
        height: "100%",
        backgroundColor: "#FFFFFF",
        display: 'flex',
        flexDirection: 'row',
        padding: "6px 0 6px 12px",
        alignItems: "center",
        borderBottom: "solid thin #55555555"
    },
    title: {
        fontSize: "1.1em"
    },
    count: {
        marginLeft: 12,
        height: "fit-content",
        padding: "0px 4px",
        backgroundColor: "green",
        borderRadius: 100,
        color: "white",
    }
}
const NotificationHeader = ({ classes, count }) => {
    return (
        <div className={classes.root}>
            <div className={classes.title}>
                Notifications
            </div>
            <div className={count ? classes.count : ""}>
                {count || ""}
            </div>
        </div>
    );
}

const NotificationHeaderContainer = withStyles(style, { name: "NotificationHeader" })(NotificationHeader)
export default NotificationHeaderContainer;