import * as types from "./index";

export const getNotificationsFromSocketAction = (notifications) => {
    return {
        type: types.GET_NOTIFICATIONS_SOCKET,
        notifications
    }
};
