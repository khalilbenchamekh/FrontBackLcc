import {put, call, select} from 'redux-saga/effects';
import _ from 'underscore';
import * as types from '../actions'
import {getNotifications} from '../services/notificationsService';
import * as selectors from "../selectors/notifications";
import {updatTilte} from "../utils";
import {getState} from "./messagerie/messagerieSaga";
import audioSrc from "../assets/definite.mp3";

const audio = new Audio(audioSrc);

export function* getNotificationsListSaga(payload) {
    try {
        yield [
            put({type: types.SET_LOADING, payload: true})
        ];
        let response = yield call(getNotifications, payload);
        if (response.data) {
            let data = response.data;
            yield [
                put({type: types.SET_NOTIFICATIONS, response: data}),
                put({type: types.SET_LOADING, payload: false})
            ];
        }

    } catch (error) {
        yield [
            put({type: types.SET_LOADING, payload: false})
        ];
    }
}

function makeIdsToNotifacations(maxValue, notifications) {
    return _.map(notifications, function (o) {
        maxValue = maxValue + 1;
        o.id = maxValue;
        return o;
    });

}

export function* countDownRecievedSaga(payload) {
    try {
        let newCountDown = payload.payload.newCountDown;
        if (newCountDown) {
            let state = yield select(getState);
            const notifications = yield selectors.notifications(state);
            let max = _.max(notifications, function (o) {
                return o.id;
            });
            let maxId =max.id;
            if(maxId){
                newCountDown = makeIdsToNotifacations(maxId, newCountDown);
                audio.play();
                let unread = updatTilte(notifications, true);
                yield [
                    put({
                        type: types.INCREMENT_UNRREAD_NOTIFICATIONS_TO_DOCUMENT, response: {
                            data: newCountDown,
                            unread: unread
                        }
                    })
                ];
            }

        }

    } catch (error) {
        console.log(error);
        yield put({type: types.GET_BUSINESS_ERROR, error});
    }
}

export function* logsRecievedSaga(payload) {
    try {
        let logs = payload.payload.logs;
        if (logs) {
            let subj = logs.subject;
            if (subj) {
                let state = yield select(getState);
                const notifications = yield selectors.notifications(state);
                audio.play();
                let unread = updatTilte(notifications, true);
                logs.description = subj;
                yield [
                    put({
                        type: types.INCREMENT_UNRREAD_NOTIFICATIONS_TO_DOCUMENT, response: {
                            data: logs,
                            unread: unread
                        }
                    })
                ];
            }
        }

    } catch (error) {
        console.log(error);
        yield put({type: types.GET_BUSINESS_ERROR, error});
    }
}
