import * as Favico from 'favico.js';


export function updateObjectInArray(array, action, id) {
    return array.map((item, index) => {
        if (index !== id) {
            return item;
        }
        return {
            ...item,
            ...action
        };
    });
}

export function convertIdToStringFromArray(array) {
    if (array.length > 0) {
        for (let i = 0; i < array.length; i++) {
            let obj = {
                "value": array[i].value,
                "id": array[i].id.toString()
            };
            array[i] = obj;
        }
    }
    return array;
}

export function isEmpty(obj) {
    for (let prop in obj) {
        if (obj.hasOwnProperty(prop)) {
            return false;
        }
    }

    return JSON.stringify(obj) === JSON.stringify({});
}

export function markAsRead(state, id) {
    let conversations = state.conversations;
    conversations[id].unread = 0;
    return conversations;
}

export function addConversations(response, state) {
    let conversations = state.conversations;
    response.conversations.forEach(function (c) {
        let conversation = conversations[c.id] || {messages: [], count: 0};
        conversation = {...conversation, ...c};
        conversations = {...conversations, ...{[c.id]: conversation}}
    });
    return conversations;
}

export function addMessages(state, messages, id, count) {
    let conversations = state.conversations;
    let conversation = conversations[id] || {};
    conversation.messages = messages;
    conversation.count = count;
    conversation.loaded = true;
    conversations = {...conversations, ...{[id]: conversation}};
    return conversations;
}

export function addMessage(state, message, id) {
    let conversations = state.conversations;
    conversations[id].count++;
    conversations[id].messages.push(message);
    return conversations;
}

export function IncrementUnread(state, id) {
    let conversations = state.conversations;
    let conversation = conversations[id];
    if (conversation) {
        conversation.unread++;
        conversations[id] = conversation;
    }
    return conversations;
}

export function prependMessages(state, messages, id) {
    let conversations = state.conversations;
    let conversation = conversations[id] || {};
    conversation.messages = [...messages, ...conversation.messages];
    conversations = {...conversations, ...{[id]: conversation}};
    return conversations;
}

export function readMessage(state, message) {
    let conversations = state.conversations;
    let conversation = conversations[message.from_id];
    if (conversation && conversation.messages) {
        let msg = conversation.messages.find(m => m.id === message.id);
        if (msg) {
            msg.read_at = (new Date()).toISOString();
            conversation.messages[message.id] = msg;
            conversations[message.from_id] = conversation;
        }
    }
    return conversations;
}

const title = document.title;
const Favicon = new Favico({
    animation: 'none'
});

function updatTilteToConversations(conversations) {
    let emptyConversations = isEmpty(conversations);
    let unread = !emptyConversations ? Object.values(conversations).reduce((acc, conversation) => conversation.unread + acc, 0) : 1;
    return unread;

}

function updateTitleToNotifications(notifications) {
    let unread = notifications.length;
    unread = unread + 1;
    return unread;

}

export const updatTilte = function (arrayCanBeConversationsOrNotifications, isNotification) {
    let unread = isNotification ?
        updateTitleToNotifications(arrayCanBeConversationsOrNotifications) :
        updatTilteToConversations(arrayCanBeConversationsOrNotifications);
    if (unread === 0) {
        document.title = title;
        Favicon.reset();
    } else {
        document.title = `(${unread} ${title})`;
        Favicon.badge(unread);
    }
    return unread;
};


