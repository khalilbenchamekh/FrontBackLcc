import { bindActionCreators } from 'redux';
import { connect } from 'react-redux';

import * as fromState from '../reducers';
import * as fromChats from "../reducers/messagerie/chats";
import {
    createChat,
    deleteChat,
    editUser,
    fetchAllChats,
    fetchMyChats, joinChat, leaveChat, logout,
    mountChat,
    sendMessage, setActiveChat,
    socketsConnect,
    unmountChat
} from "../actions/messagerie";
import ChatPage from "../components/Messagerie/ChatPage";

const mapStateToProps = (state) => {
  const activeChat = fromChats.getById(state.chats, state.chats.activeId);

  return {
    isAuthenticated: state.auth.isAuthenticated,
    chats: {
      active: activeChat,
      my: fromChats.getByIds(state.chats, state.chats.myIds),
      all: fromChats.getByIds(state.chats, state.chats.allIds),
    },
    activeUser: {
      ...state.auth.user,
      isMember: fromState.isMember(state, activeChat),
      isCreator: fromState.isCreator(state, activeChat),
      isChatMember: fromState.isChatMember(state, activeChat),
    },
    messages: state.messages,
    error: state.services.errors.chat,
    isConnected: state.services.isConnected,
  };
};

const mapDispatchToProps = dispatch =>
  bindActionCreators(
    {
      fetchAllChats,
      fetchMyChats,
      setActiveChat,
      logout,
      createChat,
      deleteChat,
      joinChat,
      leaveChat,
      editUser,
      sendMessage,
      mountChat,
      unmountChat,
      socketsConnect,
    },
    dispatch,
  );

export default connect(mapStateToProps, mapDispatchToProps)(ChatPage);
