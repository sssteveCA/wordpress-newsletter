//import axios from '../../node_modules/axios/index';
import axios from 'axios';
import { Constants } from '../namespaces/constants';
//import axios from '../../node_modules/axios/index';

export const clientDelete = axios.create({
    baseURL: Constants.HOME_URL,
    responseType: 'text',
    timeout: 20000
})

export const clientGet = axios.create({
    baseURL: Constants.HOME_URL,
    responseType: 'text',
    timeout: 20000,
});

export const clientPost = axios.create({
    baseURL: Constants.HOME_URL,
    headers: {
        'Content-Type' : 'application-json', 'Accept': 'application/json'
    },
    responseType: 'text',
    timeout: 20000,
});

export const clientPostNoTimeout = axios.create({
    baseURL: Constants.HOME_URL,
    headers: {
        'Content-Type' : 'application-json', 'Accept': 'application/json'
    },
    responseType: 'text',
})

export const clientPut = axios.create({
    baseURL: Constants.HOME_URL,
    headers: {
        'Content-Type': 'application/json', 'Accept': 'application/json'
    },
    responseType: 'text',
    timeout: 20000,
    
    
});