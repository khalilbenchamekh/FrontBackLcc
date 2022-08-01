import { withStyles } from '@material-ui/core';
import React from 'react';
import { Link } from 'react-router-dom';

const style = {
    root: {
        height: "100%",
        backgroundColor: "#FFFFFF",
        display: 'flex',
        flexDirection: 'row',
        padding: "0 12px 2px 0",
        alignItems: "center",
        justifyContent: "flex-end",
        borderTop: "solid thin #55555555"
    },
    title: {
        color: '#007bff',
        cursor: 'pointer',
        textDecoration: 'underline',
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
const NotificationFooter = ({ classes, onViewMoreClick }) => {
    return (
        <div className={classes.root}>
            <Link to="/notifications">
                <div className={classes.title} onClick={onViewMoreClick}>
                    Voire Plus
                </div>
            </Link>
        </div>
    );
}

const NotificationFooterContainer = withStyles(style, { name: "NotificationFooter" })(NotificationFooter)
export default NotificationFooterContainer;