import React, { Component } from 'react';
import PropTypes from 'prop-types';
import { withStyles } from '@material-ui/styles';
import { TextArea } from 'devextreme-react';
import { Send } from '@material-ui/icons';

const styles = {
    root: {
        display: "flex",
        flexDirection: "row",
        justifyContent: "center",
        padding: "4px 5px",
        flexGrow: 1,
    },
    send: {
        justifyContent: "center",
        flexBasis: "8%",
        alignSelf: "center",
        cursor: "pointer",
        display: "flex",
    },
    message: {
        flexGrow: 1,
        paddingLeft: 10,
        resize: "none"
    },
    sendButton: {
        "&:hover": {
            backgroundColor: "#007bff",
        }, "&:active": {
            border: "solid thin #ffffff",
        },
        border: "solid thin #007bff66",
        padding: "8px",
        paddingLeft: "10px",
        borderRadius: "100px",
        backgroundColor: "#007bffaa",
        color: "white",
    }
};

const NewMessage = ({ classes }) => {
    return (
        <div className={classes.root}>
            <textarea
                className={classes.message}
                autoCapitalize
            >
            </textarea>
            <div className={classes.send}>
                <span className={classes.sendButton}><Send /></span>

            </div>
        </div>
    )
}

export default withStyles(styles)(NewMessage);