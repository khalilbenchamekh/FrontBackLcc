import * as types from "../../actions";
import {call, put, select} from "redux-saga/effects";
import {
    downloadFileFromService,
    loadConversationsService,
    loadMessagesService,
    loadPreviousMessagesService, markAsReadService,
    sendMessageService
} from "../../services/messagerie/messagerieService";
import * as selectors from "../../selectors/messagerie";
import {updatTilte} from "../../utils";
import audioSrc from '../../assets/definite.mp3';
import {getCookie, getUser} from "../../utils/cookies";
import {markAsReadAction} from "../../actions/messagerie/messagerieActions";
import {getBillService} from "../../services/annex/billServices";

let token = getCookie('token');
const audio = new Audio(audioSrc);

export function* loadConversationsSaga(payload) {
    try {
        yield [
            put({type: types.SET_LOADING, payload: true})
        ];
        let response = yield call(loadConversationsService, payload);
        yield [
            put({
                type: types.ADD_CONVERSATIONS, response: {conversations: response.conversations}
            }),
            put({type: types.SET_LOADING, payload: false})
        ];

    } catch (error) {
        yield [
            put({type: types.GET_BUSINESS_ERROR, error}),
            put({type: types.SET_LOADING, payload: false})
        ];
    }
}

export const getState = (state) => state;

export function* loadMessagesSaga(payload) {
    try {
        let conversationId = payload.payload.conversationId;
        conversationId = parseInt(conversationId, 10);
        yield [
            put({
                type: types.OPENED_CONVERSATION, response: {
                    id: conversationId
                }
            })
        ];
        let state = yield select(getState);
        const conversation = yield selectors.conversation(state, conversationId);
        if (!conversation.loaded) {
            let response = yield call(loadMessagesService, payload);
            yield [
                put({
                    type: types.ADD_MESSAGES,
                    response: {messages: response.messages, id: conversationId, count: response.count}
                })
            ];
        }
        let user = getUser();
        let user_id = user.id;
        const messages = yield selectors.messages(state, conversationId);
        for (let message of messages) {
            if (message.read_at === null && message.to_id === user_id) {
                yield put(markAsReadAction(token, message));
            }
        }
        const conversations = yield selectors.conversations(state);
        let unread = updatTilte(conversations);

        yield [
            put({
                type: types.MARK_AS_READ, response: {id: conversationId, unread: unread}
            })
        ];

    } catch (error) {
        yield put({type: types.GET_BUSINESS_ERROR, error});
    }
}

export function* sendMessageSaga(payload) {
    try {
        let userId = payload.payload.userId;
        let response = yield call(sendMessageService, payload);
        if (response.message) {
            yield [
                put({
                    type: types.ADD_MESSAGE, response: {message: response.message, id: userId}
                })
            ];
        }

    } catch (error) {
        yield put({type: types.GET_BUSINESS_ERROR, error});
    }
}

export function* loadPreviousMessagesSaga(payload) {
    try {
        let conversationId = payload.payload.conversationId;
        let state = yield select(getState);
        let message = yield selectors.messages(state, conversationId);
        message = message[0];
        if (message) {
            let url = 'api/conversations/' + conversationId + '?before=' + message.created_at;
            let response = yield call(loadPreviousMessagesService, payload, url);
            if (response.messages) {
                yield [
                    put({
                        type: types.PREPEND_MESSAGES, response: {id: conversationId, messages: response.messages}
                    })
                ];
            }
        }
    } catch (error) {
        console.error(error);
        yield put({type: types.GET_BUSINESS_ERROR, error});
    }
}

export function* setUserSaga(payload) {

    try {
        let UserId = payload.payload.userId;
        yield [
            put({
                type: types.SET_USER, response: {id: UserId}
            })
        ];

        // window.Echo = new Echo({
        //     headers: {
        //         Authorization: `Bearer ${token}`,
        //         Accept: 'application/json',
        //     },
        //     host:window.location.hostname +':6001',
        //     broadcaster: 'socket.io',
        //     client: socketio,
        // }).private(`App.User.${UserId}`).listen('NewMessage',function (e) {
        //         console.error(e.message)
        // yield [
        //     put({
        //         type: types.ADD_MESSAGE, response: {message:e.message,id:e.message.from_id}
        //     })
        // ];
        // let state = yield select(selectors.getStore);
        // const OpenedConversations = yield selectors.OpenedConversations(state);
        // const conversations = yield selectors.conversations(state);
        // if(!OpenedConversations.includes(e.message.from_id) || document.hidden){
        //     yield [
        //         put({
        //             type: types.INCREMENT_UNRREAD, response: { id:e.message.from_id}
        //         })
        //     ];
        //     audio.play();
        //     updatTilte(conversations);
        // }
        // else {
        //     yield put(markAsReadAction(token,e.message));
        // }

        // });

    } catch (error) {
        yield put({type: types.GET_BUSINESS_ERROR, error});
    }
}

export function* messageRecievedSaga(payload) {

    try {
        let message = payload.payload.message;
        if (message) {
            let files = message.files;
            message = message.message;
            if (message && files) {
                message.files = files;
                let state = yield select(getState);
                const OpenedConversations = yield selectors.OpenedConversations(state);
                const conversations = yield selectors.conversations(state);
                if (!OpenedConversations.includes(message.from_id) || document.hidden) {

                    yield [
                        put({
                            type: types.INCREMENT_UNRREAD, response: {id: message.from_id}
                        })
                    ];
                    audio.play();
                    let unread = updatTilte(conversations);
                    yield [
                        put({
                            type: types.INCREMENT_UNRREAD_TO_DOCUMENT, response: {unread: unread}
                        })
                    ];

                } else {
                    yield put(markAsReadAction(token, message));
                }

                yield [
                    put({
                        type: types.ADD_MESSAGE, response: {message: message, id: message.from_id}
                    })
                ];
            }

        }


    } catch (error) {
        console.log(error);
        yield put({type: types.GET_BUSINESS_ERROR, error});
    }
}


export function* markAsReadSaga(payload) {

    try {
        let message = payload.payload.message;
        yield call(markAsReadService, payload);
        yield put({type: types.READ_MESSAGE, response: {message: message}});

    } catch (error) {
        yield put({type: types.GET_BUSINESS_ERROR, error});
    }
}

export function* downloadFileFromSaga(payload) {

    try {
        let response = yield call(downloadFileFromService, payload);

    } catch (error) {
        yield put({type: types.DOWNLOAD_FILE_FROM_ERROR, error});
    }
}


