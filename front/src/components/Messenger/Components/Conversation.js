import React, { Component } from 'react';
import PropTypes from 'prop-types';
import { withStyles } from '@material-ui/styles';
import { Avatar } from '@material-ui/core';
import ConversationMessage from './ConversationMessage';
import Scrollbar from 'react-scrollbars-custom';
import Separator from '../../Shared/Separator';

const styles = {
    root: {
        display: "flex",
        flexDirection: "column",
        alignItems: "flex-end",
        width: "100%"
    },
    sep: {
        margin: "0 10%",
        borderBottom: "solid thin #333"
    }
};

const Conversation = ({ classes, conversation }) => {
    return (
        <div className={classes.root}>
            <Scrollbar style={{ width: "100%", height: "100%" }}>
                {
                    conversation && conversation.map((conv, index) => {
                        return (
                            <>
                                <ConversationMessage
                                    avatar={conv.avatar}
                                    name={conv.name}
                                    messages={conv.messages}
                                />
                                <Separator />
                            </>
                        )
                    })
                }
            </Scrollbar>
        </div>
    )
}
export default withStyles(styles)(Conversation);