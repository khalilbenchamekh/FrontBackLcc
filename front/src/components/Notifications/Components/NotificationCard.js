import React, { Component } from 'react';
import { withStyles } from '@material-ui/core';


const style = {
    root: {
        height: "100%",
        backgroundColor: "#FFFFFF",
        display: 'flex',
        flexDirection: 'row',
        padding: "6px 12px 1px 12px",
        alignItems: "flex-start",
        borderBottom: "solid thin #55555555"
    },
    text: {
        height: "100%",
        display: 'flex',
        flexDirection: 'column',
        padding: "0 6px",
        flexGrow: 1,
    },
    image: {
        height: "100%",
        width: "30px",
        display: 'flex',
        flexDirection: 'row',
        alignItems: "center",
        justifyContent: 'center',
        alignSelf: 'center',
        paddingBottom: "5px"
    },
    img: {
        width: "100%"
    },
    title: {
        fontWeight: 600,
    },
    description: {
        color: "#666666",
        fontSize: "0.9em",
        marginLeft: 3,
    },
    date: {
        color: "#777777",
        fontSize: "0.75em",
        alignSelf: "flex-end"
    },

}
const NotificationCard = ({ classes, type, title, description, date }) => {
    return (
        <div className={classes.root}>
            <div className={classes.image}>
                <img
                    className={classes.img}
                    src={require('./../../../assets/info.png')}
                />
            </div>

            <div className={classes.text}>
                <div className={classes.title}>
                    {title}
                </div>
                <div className={classes.description}>
                    {description}
                </div>
                <div className={classes.date}>
                    {date}
                </div>
            </div>
        </div>
    );
}

const NotificationCardContainer = withStyles(style, { name: "NotificationCard" })(NotificationCard)
export default NotificationCardContainer;