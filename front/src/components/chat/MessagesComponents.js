import React, {Component} from 'react';
import {connect} from "react-redux";
import {compose} from 'recompose';
import {getCookie, getUser} from "../../utils/cookies";
import moment from "moment";

import MessageComponent from "./MessageComponent";
import {isEmpty} from "../../utils";
import {
    downloadFileFromAction,
    loadMessagesAction,
    loadPreviousMessagesAction,
    sendMessageAction
} from "../../actions/messagerie/messagerieActions";
import * as selectors from "../../selectors/messagerie";
import {withStyles} from "@material-ui/styles";
import Conversation from "./Conversation";
import NewMessage from "./NewMessage";
import MessageList from './MessageList';
import ConversationTitle from './ConversationTitle';
import {AttachFile} from "@material-ui/icons";
import Scrollbar from 'react-scrollbars-custom';
import {Menagerie} from "../../Constansts/conversation";
import Separator from "../Shared/Separator";


const messengerStyle = {
    main: {
        display: "flex",
        flexDirection: "row",
        justifyContent: "center",
        padding: "12px 5px 6px 5px",
        cursor: "pointer",
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
    },
    rootConver: {
        display: "flex",
        flexDirection: "column",
        alignItems: "flex-end",
        width: "100%"
    },
    sep: {
        margin: "0 10%",
        borderBottom: "solid thin #333"
    },
    root: {
        display: "flex",
        flexDirection: "row",
        justifyContent: "center",
        height: "85vh",
        background: "#ffffff"
    },
    messages: {
        display: "flex",
        flexBasis: "270px",
       
    },
    chat: {
        flexGrow: 1,
        display: "flex",
        flexDirection: "column",
        justifyContent: "center",
        height: "85vh"
    },
    title: {
        display: "flex",
        flexBasis: "40px",
        background: "#ffffff",
    },
    conversation: {
        display: "flex",
        flexGrow: 1,
    },
    newMessage: {
        display: "flex",
        flexBasis: "100px",
        padding:10,
        border:'solide #000000',
    },
};

class MessagesComponents extends Component {
    constructor(props) {
        super(props);
        this.myRef = React.createRef();
        this.state = {
            content: '',
            errors: {}, loading: false,
            user: getUser() || null,
            
        };
        this.handleChange = this.handleChange.bind(this);
      
    }

    onVisible = (e) => {
        if (document.hidden === false) {
            if (this.props.match) {
                let match = this.props.match;
                if (match.params) {
                    let params = this.props.match.params;
                    if (params.id) {
                        let id = params.id;
                        let token = this.props.token === '' ? getCookie('token') : this.props.token;
                        if (token) {
                            this.props.loadMessagesAction(token, id);
                        }
                    }
                }
            }
        }
    };
  
    componentDidMount() {

         if (this.props.id) {
            let id = this.props.id;
            let token = this.props.token === '' ? getCookie('token') : this.props.token;
            if (token) {
                this.props.loadMessagesAction(token, id);
                if (this.props.messages.length < this.props.count) {
                    // document.querySelector('.messagerie__body')
                    //     .addEventListener('scroll', this.handleScroll);
                }
            }
        }
        // document.addEventListener('visibilitychange', this.onVisible);
    }
    
    handleScroll = async () => {
        let myRef = this.scrollBar;
        if (myRef) {
            let scrollTop = myRef.scrollTop;
            if (this.props.id) {
                let id = this.props.id;
                let token = this.props.token === '' ? getCookie('token') : this.props.token;
                if (token) {
                    if (scrollTop === 0) {
                        this.setState({
                            loading: true
                        });
                        window.removeEventListener('scroll', this.handleScroll);
                        let previousgeight = this.scrollBar.scrollHeight;

                        await this.props.loadPreviousMessagesAction(token, id);
                        process.nextTick(() => {
                            this.scrollBar.scrollTop = myRef.scrollHeight - previousgeight
                        });

                        if (this.props.messages.length < this.props.count) {
                            window.addEventListener('scroll', this.handleScroll)
                        }
                        this.setState({
                            loading: false
                        });
                    }
                }

            }
        }

    };

    componentWillUnmount() {
        window.scrollTo(0, this.myRef.current.offsetTop)
         document.removeEventListener('visibilitychange', this.onVisible)
    }

    componentWillReceiveProps(nextProps, nextContext) {
        if (nextProps.LastMessages !== this.props.LastMessages) {
            this.scrollbot();
        }
        if (nextProps.id !== this.props.id && this.props.id) {
            let id = nextProps.id;
            let token = this.props.token === '' ? getCookie('token') : this.props.token;
            if (token) {
                this.props.loadMessagesAction(token, id);
                if (this.props.messages.length < this.props.count) {
                    // document.querySelector('.messagerie__body')
                    //     .addEventListener('scroll', this.handleScroll);
                }
            }
        }
    }

    scrollbot = () => {
        process.nextTick(() => {
            this.myRef.current.scrollTop = this.myRef.current.scrollHeight
        });
    };

    handleChange(e) {
        const value = e.target.value;
        this.setState({
            content: value
        });
    };

    handleClick(fileName) {
        let tokenDec = this.props.token === '' ? getCookie('token') : this.props.token;
        if (tokenDec) {
            this.props.downloadFileFromAction(tokenDec, fileName, Menagerie);
        }
    }

    attachFileMessage(files) {
        let div = [];
        if (files.length > 0) {
            for (let i = 0; i < files.length; i++) {
                let file = files[i];
                div.push(
                    <p onClick={() => this.handleClick(file.fileName)}>
                        <AttachFile/> {file.fileName}
                    </p>)
            }
        }
        return div;
    }

    messagesDiv(messages) {
        let div = [];
        const {user} = this.state;
        let id = user ? user.id : null;
        if(id){
            messages.map((msg, index) => {
                let isMe = msg.from_id === id || false;
                let nom = isMe ? 'Moi' : msg.from ? msg.from.name : 'Moi';
                let ago = moment(msg.created_at).fromNow();
                div.push(<li key={nom + "-" + index}>
                    <div
                        className={isMe ? 'col  col-md-10 offset-md-2 text-right' : 'col  col-md-10'}>
                        <p><strong>
                           <div>{nom}</div> <br/>
                        </strong>
                        <div >
                           <span  className={isMe ? 'p-2  font-weight-bold  rounded' : 'p-2 font-weight-bold rounded'}  style={isMe ? {backgroundColor: '#efefef' } :{ backgroundColor: '#e8f1f3'}}>{msg.content}</span> 
                        </div><div className='mt-2'>{ago}</div><br/>
                        </p>
                        {msg.files && (this.attachFileMessage(msg.files))}
                    </div>
                </li>);
            });
        }

        return div;

    }

    render() {
        const {
            classes,
            messages, name
        } = this.props;

        return (
            <div className={classes.chat}>
                <div className={classes.root}>

                    <div className={classes.chat}>
                        <div className={classes.title}>
                            {
                                name && <ConversationTitle name={name}
                                                           avatar="https://media-exp1.licdn.com/dms/image/C4D03AQGOLJRUCzA2lw/profile-displayphoto-shrink_200_200/0?e=1593648000&v=beta&t=V1SSF9Dv6z2yJM47SKXSmjxGHqe2WM02NVLQlb2m4q8"/>
                            }
                        </div>
                        <div className={classes.conversation}>
                            <div className={classes.rootConver}>
                                <Scrollbar style={{width: "100%", height: "100%"}}
                                           ref={e => this.scrollBar = e}
                                           onScroll={this.handleScroll}>
                                    {
                                        messages && <>
                                            <div className={classes.main}>
                                                <div className={classes.message}>
                                                    <div className="text-secondary">
                                                        <ul className={classes.list}>
                                                            {messages && (this.messagesDiv(messages))}
                                                        </ul>
                                                        
                                                    </div>
                                                </div>
                                            </div>

                                            <Separator/>
                                        </>
                                    }
                                </Scrollbar>
                            </div>


                        </div>
                        <div className={classes.newMessage}>
                            <NewMessage/>
                        </div>
                    </div>
                </div>
            </div>
        )
    }


}

const mapDispatchToProps = {
    loadMessagesAction,
    downloadFileFromAction
    ,
    loadPreviousMessagesAction
};

function mapStateToProps(state, ownProps) {
    const id = ownProps.id;
    const messages = id ? selectors.messages(state, id) : undefined;
    const count = id ? selectors.conversation(state, id).count : 0;
    const name = id ? selectors.conversation(state, id).name : "";
    return {
        token: state.login.token,
        id: id,
        messages: messages,
        count: count,
        name: name,
        conversations: state.conversations.conversations,
        LastMessages: this.messages && this.messages[this.messages.length - 1]
    };
}

export default compose(
    withStyles(messengerStyle, {
        name: "messengerStyle"
    }),
    connect(mapStateToProps, mapDispatchToProps)
)(MessagesComponents);





