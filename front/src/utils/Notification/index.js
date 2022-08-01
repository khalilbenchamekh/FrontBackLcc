import _ from 'underscore';

export function notificationIfArrayOrObject(data, array) {
    let isArray = _.isArray(data);
    if (isArray === true) {
        array.concat(data);
    } else {
        if (data) {
            array.push(data);
        }
    }
    return array;
}
