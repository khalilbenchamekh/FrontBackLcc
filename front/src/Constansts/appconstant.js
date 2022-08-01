import * as moment from "moment";

export const localeEn = moment.locale('es');
export const gender = [{
    value: "female"
    , label: "femelle"
}, {
    value: "male"
    , label: "mâle"
}];
export const workplace = [{
    value: "Ground"
    , label: "terrain"
}, {
    value: "Office"
    , label: "Bureau"
}];
let brodCasterValue = [
    'pusher',
    'socket.io'
];
export const brodcaster = brodCasterValue[0];
export const cluster = 'eu';
export const encrypted = true;
export const forceTLS = true;
export const PUSHER_APP_ID = '1045804';
export const PUSHER_APP_KEY = '111ba163d4086e897500';
export const PUSHER_APP_SECRET = '89efee43c665622bb33b';
