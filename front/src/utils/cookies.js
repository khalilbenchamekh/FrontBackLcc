import * as jwtJsDecode from "jwt-js-decode";
import {owner, userRole} from "../Constansts/file";

export function setCookie(cname, cvalue, days, isJson = false) {
    let d = new Date();
    d.setTime(d.getTime() + (days * 24 * 60 * 60 * 1000)); // (exdays * 24 * 60 * 60 * 1000));
    let expires = 'expires=' + d.toUTCString();
    document.cookie = cname + '=' +
        cvalue + ';' + expires + ';path=/';
}

export function deleteCookie(name) {
    setCookie(name, null, 0);
}

export function getProfileFromCookie() {

    let data = localStorage.getItem('avatar');
    if (data) {
        let obj = JSON.parse(data);
        if (obj) {
            return obj;

        }
    }

    return null;
}

export function getCookie(cname, isJson = false) {
    let name = cname + '=';
    let ca = document.cookie.split(';');
    if (isJson) {

    } else {
        for (let i = 0; i < ca.length; i++) {
            let c = ca[i];
            while (c.charAt(0) === ' ') {
                c = c.substring(1);
            }
            if (c.indexOf(name) === 0) {
                return c.substring(name.length, c.length);
            }
        }
    }


    return '';
}

export function getUser() {
    let token = getCookie('token');
    if (token !== '') {
        let user = jwtJsDecode.jwtDecode(token);
        let payload = user.payload;
        return payload;
    }
}

export function isOwner(isOwnerRole) {
    let data = checkCookie();
    let valueToReturned = null;
    if (data) {
        if (isOwnerRole) {
            if (data === owner) {
                valueToReturned = owner;
            }
        } else {
            valueToReturned = userRole;
        }
    }
    return valueToReturned;
}

export function checkCookie() {
    let user = getCookie('token');
    let role;
    if (user !== '') {
        role = jwtJsDecode.jwtDecode(user);
        let payload = role.payload;
        if (payload) {
            payload = payload.role;
        } else {
            payload = userRole;
        }

        return payload;
    } else {
        return null;
    }
}
