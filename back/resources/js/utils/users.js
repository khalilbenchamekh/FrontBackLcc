import {getAuthToken} from "./auth";
import axios from "axios";

const REST_ENDPOINT = 'http://localhost:8000/'

export const getCountUsers=async () => {
    try {
        const token = getAuthToken()
        const config={
            headers: { Authorization: `Bearer ${token}` }
        }
        const response = await axios.get(`${REST_ENDPOINT}api/super/users/count`,config)
        if(response){
            return  response
        }
    } catch (e) {
        return null
    }
}
export const getAllUsers=async (data) => {
    try {
        const token = getAuthToken()
        const body=data
        const config = {
            headers: {Authorization: `Bearer ${token}`}
        }
        const response = await axios.post(`${REST_ENDPOINT}api/super/users`,body, config)
        if (response) {
            return response
        }
    } catch (e) {
        return null
    }
}
export const activerUser=async (id) => {
    try {
        const token = getAuthToken()
        const config = {
            headers: {Authorization: `Bearer ${token}`}
        };
        const response = await axios.get(`${REST_ENDPOINT}api/super/user/enable/${id}`, config)
        if (response) {
            return response
        }
    } catch (e) {
        console.error(e)
    }
}
export const desactiverUser=async (id) => {
    try {
        const token = getAuthToken()
        const config = {
            headers: {Authorization: `Bearer ${token}`}
        };
        const response = await axios.get(`${REST_ENDPOINT}api/super/user/disable/${id}`, config)
        if (response) {
            return response
        }
    } catch (e) {
        console.error(e)
    }
}
export const blockUser=async (id) => {
    try {
        const token = getAuthToken()
        const config = {
            headers: {Authorization: `Bearer ${token}`}
        };
        const response = await axios.get(`${REST_ENDPOINT}api/super/user/block/${id}`, config)
        if (response) {
            return response
        }
    } catch (e) {
        console.error(e)
    }
}
export const getUser=async (id) => {
    try {
        const token = getAuthToken()
        const config = {
            headers: {Authorization: `Bearer ${token}`}
        };
        const response = await axios.get(`${REST_ENDPOINT}api/super/user/get/${id}`, config)
        if (response) {
            return response
        }
    } catch (e) {
        return null;
    }
}
export const getImage=async (id) => {
    try{
        const token=getAuthToken()
        const config={
            headers:{Authorization:`Bearer ${token}`},
            responseType: 'blob'
        }
        const response = await axios.get(`${REST_ENDPOINT}api/super/user/image/get/${id}`,config)

        if(response.status===200){
            const url=window.URL||window.webkitURL
            console.log(response)
            return  url.createObjectURL(response.data)
        }else {
            return null
        }

    }catch (e){
        return null
    }
}
export const editUser=async (id, data) => {
    try {
        const token = getAuthToken()
        const config = {
            headers: {Authorization: `Bearer ${token}`}
        }
        const response = await axios.post(`${REST_ENDPOINT}api/super/user/edit/${id}`,data,config)
        if(response){
            return response
        }
    } catch (e) {
        return null;
    }
}
export const saveUser=async (data) => {

    const token = getAuthToken();
    const config = {
        'Authorization': `Bearer ${token}`,
        'Accept': 'application/json',
        'Content-Type': 'application/json'
    }
    const rawResponse = await fetch(`${REST_ENDPOINT}api/super/user/save`, {
        method: 'POST',
        headers: config,
        body: JSON.stringify(data)
    });
    return rawResponse;
}
export const saveImageUser=async (id,data) => {
    try {
        const token = getAuthToken()
        let fd = new FormData()

        fd.append('avatar', data)

        const bodyParameters = fd;
        const config = {
            headers: {Authorization: `Bearer ${token}`}
        };
        const response = await axios.post(`${REST_ENDPOINT}api/super/user/image/save/${id}`, bodyParameters, config)
        if (response) {
            return response
        }
    } catch (e) {
        return null;
    }
}

// try {
//     const token = getAuthToken()
//     const config = {
//         headers: {Authorization: `Bearer ${token}`},
//         responseType: 'blob'
//     };
//     const response = await axios.get(`${REST_ENDPOINT}api/super/user/image/get/${id}`, config)
//     if (response.status===200) {
//         const urlCreator = window.URL || window.webkitURL
//         return urlCreator.createObjectURL(response.data)
//     }else {
//         return null;
//     }
// } catch (e) {
//     return null;
// }
