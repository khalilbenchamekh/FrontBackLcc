import * as types from "../index";
import { messageRecievedSaga } from "../../sagas/messagerie/messagerieSaga";

export const loadConversationsAction = (token) => {
    return {
        type: types.LOAD_CONVERSATIONS,
        payload: { token: token }
    }
};

export const loadMessagesAction = (token, conversationId) => {
    return {
        type: types.LOAD_MESSAGES,
        payload: { token: token, conversationId: conversationId }
    }
};

export const loadPreviousMessagesAction = (token, conversationId) => {
    return {
        type: types.LOAD_PREVIOUS_MESSAGES,
        payload: { token: token, conversationId: conversationId }
    }
};

export const markAsReadAction = (token, message) => {
    return {
        type: types.MARK_AS_READ,
        payload: { token: token, message: message }
    }
};
export const messageRecievedAction = (message) => {
    return {
        type: types.MESSAGE_RECIEVED,
        payload: { message: message }
    }
};

export const sendMessageAction = (token, obj, userId) => {
    return {
        type: types.SEND_MESSAGE,
        payload: { token: token, obj: obj, userId: userId }
    }
};
export const setUserAction = (userId) => {
    return {
        type: types.SET_USER,
        payload: { userId: userId }
    }
};
export const addSingleConversation = (friend) => {
    return {
        type: types.ADD_SINGLE_CONVERSATIONS,
        payload: friend
    }
};

export const downloadFileFromAction = (token, filename, type) => {
    return {
        type: types.DOWNLOAD_FILE_FROM,
        payload: {
            token: token,
            obj: {
                filename: filename, type: type
            }
        }
    }
}
