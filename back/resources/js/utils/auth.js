import decode from 'jwt-decode'
import axios from 'axios'

const REST_ENDPOINT = 'http://localhost:8000/'
const AUTH_TOKEN_KEY = 'authToken'

export async function loginUser(email, password) {

    try {
        const res = await axios({
            url: `${REST_ENDPOINT}api/connexion`,
            method: 'POST',
            data: {
                email: email,
                password: password,
            }
        });

        if(res){
            if(res.data){
                const token = res.data.token;
                setAuthToken(token)
            }
        }
    } catch (err) {
        console.error('Caught an error during login:', err)
    }
}

export function logoutUser() {
    clearAuthToken()
}

export function setAuthToken(token) {
    axios.defaults.headers.common['Authorization'] = `Bearer ${token}`
    localStorage.setItem(AUTH_TOKEN_KEY, token)
}

export function getAuthToken() {
    return localStorage.getItem(AUTH_TOKEN_KEY)
}

export function clearAuthToken() {
    axios.defaults.headers.common['Authorization'] = ''
    localStorage.removeItem(AUTH_TOKEN_KEY)
}

export function isLoggedIn() {
    let authToken = getAuthToken()
    return authToken && !isTokenExpired(authToken)
}

export function getUserInfo() {
    if (isLoggedIn()) {
        return decode(getAuthToken())
    }
}

function getTokenExpirationDate(encodedToken) {
    let token = decode(encodedToken)
    if (!token.exp) {
        return null
    }

    let date = new Date(0)
    date.setUTCSeconds(token.exp)

    return date
}

function isTokenExpired(token) {
    let expirationDate = getTokenExpirationDate(token)
    return expirationDate < new Date()
}
