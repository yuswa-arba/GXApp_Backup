/**
 * Created by kevinpurwono on 9/11/17.
 */
import axios from 'axios'
import Auth from '../store/auth'
import {faceBaseUrl, faceSubKey}  from './const'
export function get(url) {
    return axios({
        method: 'GET',
        url: url,
        headers: {
            // 'Authorization': `Bearer ${Auth.state.api_token}`
        }
    })
}

export function post(url, payload) {
    return axios({
        method: 'POST',
        url: url,
        data: payload,
        headers: {
            // 'Authorization': `Bearer ${Auth.state.api_token}`,
        }
    })
}

export function multipartPost(url, payload) {
    return axios({
        method: 'POST',
        url: url,
        data: payload,
        headers: {
            // 'Authorization': `Bearer ${Auth.state.api_token}`,
            'Content-Type': 'multipart/form-data'
        }
    })
}

// delete is reserved keyword
export function del(url) {
    return axios({
        method: 'DELETE',
        url: url,
        headers: {
            // 'Authorization': `Bearer ${Auth.state.api_token}`
        }
    })
}

export function interceptors(cb) {
    axios.interceptors.response.use((res) => {
        return res;
    }, (err) => {
        cb(err)
        return Promise.reject(err)
    })
}


export function faceGet(url, payload) {
    return axios({
        method: 'GET',
        url: url,
        data: payload,
        headers: {
            'Content-Type': 'application/json',
            'Ocp-Apim-Subscription-Key': faceSubKey,
        }
    })
}

export function facePut(url, payload) {
    return axios({
        method: 'PUT',
        url: url,
        data: payload,
        headers: {
            'Content-Type': 'application/json',
            'Ocp-Apim-Subscription-Key': faceSubKey,
        }
    })
}

export function faceDel(url) {
    return axios({
        method: 'DELETE',
        url: url,
        headers: {
            'Content-Type': 'application/json',
            'Ocp-Apim-Subscription-Key': faceSubKey,
        }
    })
}


export function facePost(url, payload) {
    return axios({
        method: 'POST',
        url: url,
        data: payload,
        headers: {
            'Content-Type': 'application/json',
            'Ocp-Apim-Subscription-Key': faceSubKey,
        }
    })

}
export function facePutOctet(url, data) {
    return axios({
        method: 'PUT',
        url: url,
        data: data,
        headers: {
            'Content-Type': 'application/octet-stream',
            'Ocp-Apim-Subscription-Key': faceSubKey,
        }
    })

}

export function facePostOctet(url, data) {
    return axios({
        method: 'POST',
        url: url,
        data: data,
        headers: {
            'Content-Type': 'application/octet-stream',
            'Ocp-Apim-Subscription-Key': faceSubKey,
        }
    })

}
