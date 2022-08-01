import React, { Component } from 'react';
import PropTypes from 'prop-types';
import { compose } from 'recompose';
import { withStyles } from '@material-ui/styles';
import { connect } from 'react-redux';
import MessageList from './Components/MessageList';
import { Title } from '@material-ui/icons';
import ConversationTitle from './Components/ConversationTitle';
import NewMessage from './Components/NewMessage';
import Conversation from './Components/Conversation';

const messengerStyle = {
  root: {
    display: "flex",
    flexDirection: "row",
    justifyContent: "center",
    height: "85vh",
    border: "solid thin #4099ff",
    background: "#ffffff"
  },
  messages: {
    display: "flex",
    flexBasis: "270px",
    background: "linear-gradient(90deg, #4099ff, #73b4ff);",
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
    background: "linear-gradient(90deg, #62bbff, #ffffff 80%);",
  },
  conversation: {
    display: "flex",
    flexGrow: 1,
  },
  newMessage: {
    display: "flex",
    flexBasis: "100px",
  }
};
const messages = [
  {
    name: "Amine ZEROUALI",
    avatar: "https://media-exp1.licdn.com/dms/image/C4D03AQGOLJRUCzA2lw/profile-displayphoto-shrink_200_200/0?e=1593648000&v=beta&t=V1SSF9Dv6z2yJM47SKXSmjxGHqe2WM02NVLQlb2m4q8",
    message: "Afenn a drari"
  },
  {
    name: "Khalil Benchamekh",
    avatar: "https://media-exp1.licdn.com/dms/image/C4D03AQGhTqL3bSqWlQ/profile-displayphoto-shrink_200_200/0?e=1593648000&v=beta&t=MYXsRgIVkLN3IPN8yLMhdeCtJLRCGz0PcVxBrDziny4",
    message: "Drari nodo tselliw"
  },
  {
    name: "Khalil Elghabi",
    avatar: "https://media-exp1.licdn.com/dms/image/C5603AQGsTI62BCecuw/profile-displayphoto-shrink_200_200/0?e=1593648000&v=beta&t=bsSurJchxjVrIryEyLOw1_gWBMCfHK2g18_93zxy5sE",
    message: "Inni Ad3okom ila dinin jadid"
  },
]

const conversation = [
  {
    name: "Amine ZEROUALI",
    avatar: "https://media-exp1.licdn.com/dms/image/C4D03AQGOLJRUCzA2lw/profile-displayphoto-shrink_200_200/0?e=1593648000&v=beta&t=V1SSF9Dv6z2yJM47SKXSmjxGHqe2WM02NVLQlb2m4q8",
    messages: [
      {
        content: "Afeen a Drari",
      },
      {
        content: "Khasna chi tserkila mora corona"
      },
      {
        link: "https://mans.io/images/1067490/1146234.jpg",
        type: "file",
        content: "Destination.png"
      },
      {
        link: "https://mans.io/images/1067490/1146234.jpg",
        type: "file",
        content: "Destination2.mp4"
      }
    ]
  },
  {
    name: "Khlil Benchamekh",
    avatar: "https://media-exp1.licdn.com/dms/image/C4D03AQGhTqL3bSqWlQ/profile-displayphoto-shrink_200_200/0?e=1593648000&v=beta&t=MYXsRgIVkLN3IPN8yLMhdeCtJLRCGz0PcVxBrDziny4",
    messages: [
      {
        content: "Ikhwan yalaho nmchiw",
      },
      {
        content: "chamal"
      },
      {
        link: "https://mans.io/images/1067490/1146234.jpg",
        type: "file",
        content: "Tetouan.png"
      },
      {
        link: "http://unf3s.cerimes.fr/media/paces/Grenoble_1112/boumendjel_ahcene/boumendjel_ahcene_p10/boumendjel_ahcene_p10.pdf",
        type: "file",
        content: "Tetouaaan.mp4"
      }
    ]
  }
]
class MessengerPage extends Component {
  constructor() {
    super();
    this.state = {
      selectedConversation: {
        title: "",
        avatar: "",
      }
    }
  }
  handleMessageChange = (person) => {
    const { selectedConversation } = this.state;
    this.setState({ selectedConversation: { ...selectedConversation, title: person.name, avatar: person.avatar } });
  }
  render() {
    const { classes } = this.props;
    const { selectedConversation } = this.state;
    return (
      <div className={classes.root}>
        <div className={classes.messages}>
          <MessageList messages={messages} onMessageChange={this.handleMessageChange} />
        </div>
        <div className={classes.chat}>
          <div className={classes.title}>
            <ConversationTitle
              name={selectedConversation.title}
              avatar={selectedConversation.avatar} />
          </div>
          <div className={classes.conversation}>
            <Conversation conversation={conversation || {}} />
          </div>
          <div className={classes.newMessage}>
            <NewMessage />
          </div>
        </div>
      </div>
    );
  }
}


const mapDispatchToProps = {};

const mapStateToProps = (state) => ({ ...state })
export default compose(
  withStyles(messengerStyle, {
    name: "messengerStyle"
  }),
  connect(mapStateToProps, mapDispatchToProps)
)(MessengerPage);