import React, { Component } from 'react';
import PropTypes from 'prop-types';
import { withStyles } from '@material-ui/styles';
import Message from './Message';
import Scrollbar from "react-scrollbars-custom";
import Separator from '../Shared/Separator';

const style = {
    root: {
        display: "flex",
        flexDirection: "column",
        justifyContent: "center",
        height: "85vh",
        flexGrow: 1,
        borderRight: "solid #00000022 thin",
    },
    title: {
        width: "100%",
        textAlign: "center",
        display: "table-cell",
        verticalAlign: "middle",
        flexBasis: "49px",
        fontWeight: "bolder",
        padding: "4px 5px",
    },
    messages: {
        flexGrow: 1,
        overflowY: "auto"
    }
};

const MessageList = ({ classes, messages }) => {
    return (
        <div className={classes.root}>
            {/* title */}
            <div className={classes.title}>
                List des Messages
            </div>
            {/* messages */}
            <div className={classes.messages}>
                <Scrollbar style={{ width: "100%", height: "100%" }}>
                    {
                        messages.map((message, index) => {
                            return (
                                <>
                                    <Message
                                        keu={index}
                                        data={message}
                                    />
                                    <Separator />
                                </>
                            )
                        })
                    }
                </Scrollbar>
            </div>
        </div>
    )
}

export default withStyles(style)(MessageList);