export const conversations = (state) => state.conversations.conversations;
export const getStore = (state) => state;

export const conversation = (state, id) => {
    try {
        let convs = conversations(state);
        convs = convs[id] || {};
        return convs;
    } catch (e) {
        return {};
    }
};

export const messages = (state, id) => {
    try {
        let conv = conversation(state,id);
        conv = conv && conv.messages ?
            conv.messages : [];
        return conv;
    } catch (e) {
        return [];
    }
};
export const OpenedConversations = (state) => state.conversations.OpenedConversations;



