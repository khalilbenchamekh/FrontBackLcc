import axios from "axios";
import {getAuthToken} from "./auth";

const REST_ENDPOINT = 'http://localhost:8000/'

    export const getOrganisations=async (data) => {

    try {
        const token = getAuthToken()
        const bodyParameters = data;
        const config = {
            headers: { Authorization: `Bearer ${token}` }
        };
        const response = await axios.post(`${REST_ENDPOINT}api/super/organisations`,bodyParameters,config)
        if(response){
            return response.data
        }
    }catch (e){
        console.error(e)
    }

}
    export const activerOrganisation=async (id) => {
    try {
        const token = getAuthToken()
        const config = {
            headers: {Authorization: `Bearer ${token}`}
        };
        const response = await axios.get(`${REST_ENDPOINT}api/super/organisation/enable/${id}`, config)
        if (response) {
            return response.data
        }
    } catch (e) {
        console.error(e)
    }
}
    export const blockOrganisation=async (id) => {
    try {
        const token = getAuthToken()
        const config = {
            headers: {Authorization: `Bearer ${token}`}
        };
        const response = await axios.get(`${REST_ENDPOINT}api/super/organisation/block/${id}`, config)
        if (response) {
            return response.data
        }
        }catch(e)
        {
            console.error(e)
        }
    }
    export const disactiverOrganisation = async (id) => {
        try {
            const token = getAuthToken()
            const config = {
                headers: {Authorization: `Bearer ${token}`}
            };
            const response = await axios.get(`${REST_ENDPOINT}api/super/organisation/disable/${id}`, config)
            if (response) {
                return response.data
            }
        } catch (e) {
            console.error(e)

        }
    }
    export const getImageOrganiastion = async (id) => {
        try {
            const token = getAuthToken()
            const config = {
                headers: {Authorization: `Bearer ${token}`}
                ,
                responseType: 'blob'
            };
            const response = await axios.get(`${REST_ENDPOINT}api/super/organisation/image/get/${id}`, config)
            if (response) {
                const urlCreator = window.URL || window.webkitURL
                return urlCreator.createObjectURL(response.data)
            }
        } catch (e) {
            console.error(e)

        }
    }
    export const getOrganisation = async (id) => {
        try {
            const token = getAuthToken()
            const config = {
                headers: {Authorization: `Bearer ${token}`}
            };
            const response = await axios.get(`${REST_ENDPOINT}api/super/organisation/get/${id}`, config)
            if (response) {
                return response.data
            }
        } catch (e) {
            console.error(e)

        }
    }
    export const getCto = async (id) => {
        try {
            const token = getAuthToken()
            const config = {
                headers: {Authorization: `Bearer ${token}`}
            };
            const response = await axios.get(`${REST_ENDPOINT}api/super/user/get/${id}`, config)
            if (response) {
                return response.data
            }
        } catch (e) {
            console.error(e)

        }
    }
    export const getAllUserOrganisation=async (id,data) => {
        try {
            const token = getAuthToken()
            const bodyParameters = data;
            const config = {
                headers: {Authorization: `Bearer ${token}`}
            };
            const response = await axios.post(`${REST_ENDPOINT}api/super/organisation/users/get/${id}`,bodyParameters,config)
            if (response) {
                return response.data
            }
        } catch (e) {
            return null;
        }
    }
    export const editOrganisation=async (id, data) => {
        try {
            const token = getAuthToken()
            const bodyParameters = data;
            const config = {
                headers: {Authorization: `Bearer ${token}`}
            };
            const response = await axios.post(`${REST_ENDPOINT}api/super/organisation/edit/${id}`, bodyParameters, config)
            if (response) {
                return response.data
            }
        } catch (e) {
            return null;

        }
    }
    export const imageOrganisation=async (id, data) => {
        try {
            const token = getAuthToken()
            let fd= new FormData()

            fd.append('avatar', data)

            const bodyParameters = fd;
            const config = {
                headers: {Authorization: `Bearer ${token}`}
            };
            const response = await axios.post(`${REST_ENDPOINT}api/super/organisation/image/update/${id}`, bodyParameters, config)
            if (response) {
                return response
            }
        } catch (e) {
            return null;
        }
    }
    export const saveOrganisation=async (data) => {

            const token = getAuthToken();
            const config = {
                'Authorization': `Bearer ${token}`,
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
            const rawResponse = await fetch(`${REST_ENDPOINT}api/super/organisation/save`, {
                method: 'POST',
                headers: config,
                body: JSON.stringify(data)
            });
            return rawResponse;
    }




