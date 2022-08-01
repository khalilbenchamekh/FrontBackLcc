import React, { Component } from 'react';
import { connect } from "react-redux";
import List from "@material-ui/core/List";
import ListItem from "@material-ui/core/ListItem";
import ListItemText from "@material-ui/core/ListItemText";
import { Link } from 'react-router-dom';
import { compose } from 'recompose';

import moment from "moment";
import Avatar from "@material-ui/core/Avatar";
import { getCookie, getUser } from "../../utils/cookies";
import {
    loadConversationsAction,
    messageRecievedAction,
    setUserAction,
    addSingleConversation
} from "../../actions/messagerie/messagerieActions";
import { isEmpty } from "../../utils";
import Echo from "laravel-echo";
import socketio from "socket.io-client";
import { withStyles } from "@material-ui/styles";
import Message from "./Message";
import Separator from "../Shared/Separator";
import Scrollbar from "react-scrollbars-custom";
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
        padding:'10px',
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
        overflowY: "auto",
    },
    flatAddMessage: {
    },
    titleText: {
        flexGrow: 1,
    }
};
class MessagerieComponents extends Component {
    constructor() {
        super();
        this.state = {
            addedConversations: []
        }
    }

    // componentDidMount() {
    //     let token = this.props.token === '' ? getCookie('token') : this.props.token;
    //     if (token) {
    //         let user = getUser();
    //         let user_id = user.id;
    //         window.Echo = new Echo({
    //             headers: {
    //                 'X-Requested-With': 'XMLHttpRequest',
    //                 'Accept': 'application/json',
    //                 'Access-Control-Allow-Origin': '*',
    //                 'Content-Type': 'application/json',
    //                 Authorization: `Bearer ${token}`,
    //             },
    //             host: window.location.hostname + ':6001',
    //             broadcaster: 'socket.io',
    //             client: socketio,
    //         }).private(`App.User.${user_id}`).listen('NewMessage', e => {
    //             this.props.messageRecievedAction(e.message);
    //         })
    //     }
    // }

    addNewConversation = (friend) => {
        const { addSingleConversation } = this.props;
        console.log("selected friend: ", friend)
        addSingleConversation({ id: friend.value, name: friend.label, messages: [], unread: 0 })
    }

    render() {
        const {
            employees, conversations, classes
        } = this.props;
        const conversatioKeys = Object.keys(conversations);
        const filteredEmps = employees.filter(emp => !conversatioKeys.some(keyName => conversations[keyName].id === Number(emp.value)));
        console.log(filteredEmps)
        return (

            <div className={classes.root}>
                {/* title */}
                <div className={classes.title}>
                    <div className={classes.titleText} >List des Messages</div>
                    <div className={classes.flatAddMessage}>
                        {/*<FriendsList*/}
                            {/*friends={filteredEmps}*/}
                            {/*onSelect={this.addNewConversation}*/}
                        {/*/>*/}
                    </div>
                </div>
                {/* messages */}
                <div className={classes.messages}>
                    {
                        !isEmpty(conversations) &&
                        <Scrollbar style={{ width: "100%", height: "100%" }}>
                            {Object.keys(conversations).map((keyName, i) => (
                                <div>
                                    <Message data={
                                        conversations[keyName]
                                    }
                                    />
                                    <Separator />
                                </div>
                            ))
                            }
                        </Scrollbar>
                    }
                </div>
            </div >

        )
    }
}


const mapDispatchToProps = {

    setUserAction,
    messageRecievedAction,
    addSingleConversation
};


function mapStateToProps(state) {
    return {
        token: state.login.token,
        conversations: state.conversations.conversations,
        employees: state.select.employees,
    };
} export default compose(
    withStyles(style, {
        name: "messengerStyle"
    }),
    connect(mapStateToProps, mapDispatchToProps)
)(MessagerieComponents);





