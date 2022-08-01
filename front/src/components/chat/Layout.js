import React, { Component } from 'react';
import { connect } from "react-redux";
import { compose } from 'recompose';
import MessagerieComponents from "./MessagerieComponents";
import { withStyles } from "@material-ui/styles";
import MessagesComponents from "./MessagesComponents";
import { getCookie } from "../../utils/cookies";
import { loadConversationsAction } from "../../actions/messagerie/messagerieActions";
import { isEmpty } from "../../utils";
import { getIdFromRoute } from "../../utils/messagerie/helperMessagerie";

import "./Chat.css";
const messengerStyle = {
    root: {
        borderRadius: '10px!important',
        display: "flex",
        flexDirection: "row",
        justifyContent: "center",
        height: "87vh",
        border: "solid thin #ffffff",
        background: "#ffffff",
        padding:"5px"
    },
    messages: {
        display: "flex",
        padding:'10px',
        flexBasis: "30%",
        background: "#ffffff",
    },
    chat: {
        flexGrow: 1,
        display: "flex",
        flexDirection: "column",
        justifyContent: "center",
        height: "85vh",
    },
};

class Layout extends Component {
    componentDidMount() {
        let token = this.props.token === "" ? getCookie("token") : this.props.token;
        let conversations = this.props.conversations;
        if (token && isEmpty(conversations)) {
            this.props.loadConversationsAction(token);
        }
       
    }
  
    render() {
        const {
            classes, id,
        } = this.props;
        return (
       
                <div className={classes.root} >
                    <div className={classes.messages}>
                        <MessagerieComponents />
                    </div>
                    <div className={classes.chat}>
                        {
                            id && <MessagesComponents id={id} />
                        }
                    </div>
                    
                </div>
           
        )
    }
}


const mapDispatchToProps = {
    loadConversationsAction
};


function mapStateToProps(state, ownProps) {
    const params = ownProps.match ? ownProps.match.params : undefined;
    const id = params ? params.id : undefined;
    return {
        token: state.login.token,
        conversations: state.conversations.conversations,
        id: getIdFromRoute(id, state.conversations.conversations),
    };
}

export default compose(
    withStyles(messengerStyle, {
        name: "messengerStyle"
    }),
    connect(mapStateToProps, mapDispatchToProps)
)(Layout);




