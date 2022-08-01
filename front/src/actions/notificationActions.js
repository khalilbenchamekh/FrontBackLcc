import * as types from "./index";

export const getNotificationsLimit = (token, start, length) => {
    return {
        type: types.GET_NOTIFICATIONS,
        payload: {token: token, start: start, length: length}
    }
};

export const countDownRecieved = (newCountDown) => {
    return {
        type: types.COUNT_DOWN_RECIEVED,
        payload: {newCountDown: newCountDown}
    }
};

export const logsRecieved = (logs) => {
    return {
        type: types.LOGS_RECIEVED,
        payload: {logs: logs}
    }
};
