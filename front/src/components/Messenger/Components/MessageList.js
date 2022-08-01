import React, { Component, useState, useEffect } from 'react';
import PropTypes from 'prop-types';
import { withStyles } from '@material-ui/styles';
import Message from './Message';
import Scrollbar from "react-scrollbars-custom";
import Separator from '../../Shared/Separator';
import AddIcon from '@material-ui/icons/Add';
import FriendsList from './FriendsList';

const style = {
    root: {
        display: "flex",
        flexDirection: "column",
        justifyContent: "center",
        height: "85vh",
        flexGrow: 1,
        borderRight: "solid #00000022 thin",
        position: "relative",
    },
    title: {
        width: "100%",
        textAlign: "center",
        display: "flex",
        verticalAlign: "middle",
        flexBasis: "49px",
        fontWeight: "bolder",
        padding: "4px 5px",
    },
    messages: {
        flexGrow: 1,
        overflowY: "auto"
    },
    flatAddMessage: {
    },
    titleText: {
        flexGrow: 1,
    }
};
const friends = [
    {
        name: "Amine ZEROUALI"
    },
    {
        name: "Khalil Benchamekh"
    },
    {
        name: "Khalil ELGHABI"
    },
]
const MessageList = ({ classes, messages, onMessageChange }) => {
    const [innerMessages, setInnerMessages] = useState(messages || []);
    const [selectedName, setSelectedName] = useState();


    const addNewConversation = (friend) => {
        if (innerMessages.filter(msg => msg.name === friend.name).length === 0) {
            setInnerMessages([...innerMessages, { name: friend.name, avatar: friend.avatar }]);
        }
    }
    const handleSelectChange = (person) => {
        setSelectedName(person.name)
        onMessageChange(person);
    }

    useEffect(() => handleSelectChange(innerMessages.length > 0 && innerMessages[0]), [])
    return (
        <div className={classes.root}>
            {/* title */}
            <div className={classes.title}>
                <div className={classes.titleText} >List des Messages</div>
                <div className={classes.flatAddMessage}>
                    <FriendsList
                        friends={friends}
                        onSelect={addNewConversation}
                    />
                </div>
            </div>
            {/* messages */}
            <div className={classes.messages}>
                <Scrollbar style={{ width: "100%", height: "100%" }}>
                    {
                        innerMessages.map((message, index) => {
                            return (
                                <>
                                    <Message
                                        name={message.name}
                                        message={message.message}
                                        avatar={message.avatar}
                                        selected={selectedName == message.name}
                                        onSelect={handleSelectChange}
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