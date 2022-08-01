import * as types from '../../actions';
import {
    addConversations,
    addMessage,
    addMessages,
    IncrementUnread,
    markAsRead,
    prependMessages,
    readMessage,
    isEmpty
} from "../../utils";
import {getUser} from "../../utils/cookies";

export default function (state = {
    user: null,
    unread: 0,
    conversations: {},
    OpenedConversations: []
}, action) {
    const response = action.response;
    switch (action.type) {
        case types.OPENED_CONVERSATION:
            return {
                ...state,
                OpenedConversations: [response.id]
            };
        case types.ADD_CONVERSATIONS:

            return {
                ...state,
                conversations: addConversations(response, state)
            };
        case types.ADD_SINGLE_CONVERSATIONS:
            return {
                ...state,
                conversations: {[action.payload.id]: {...action.payload}, ...state.conversations}
            };
        case types.ADD_MESSAGES:
            return {
                ...state,
                conversations: addMessages(state, response.messages, response.id, response.count)
            };
        case types.PREPEND_MESSAGES:
            return {
                ...state,
                conversations: prependMessages(state, response.messages, response.id)
            };
        case types.INCREMENT_UNRREAD:
            return {
                ...state,
                conversations: IncrementUnread(state, response.id)
            };

        case types.INCREMENT_UNRREAD_TO_DOCUMENT:
            return {
                ...state,
                unread:  response.unread,
            };
        case types.READ_MESSAGE:
            return {
                ...state,
                conversations: readMessage(state, response.message)
            };
        case types.ADD_MESSAGE:
            return {
                ...state,
                conversations: addMessage(state, response.message, response.id)
            };
        case types.MARK_AS_READ:
            return {
                ...state,
                conversations: markAsRead(state, response.id),
                unread: response.unread
            };
        case types.SET_USER:
            return {
                ...state,
                user: response ? response.id : getUser().id || null
            };
        default:
            return state;
    }
};
