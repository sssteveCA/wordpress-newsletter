//import axios from '../../node_modules/axios/index.js';
import { AxiosStatic } from '../../node_modules/axios/index.js';
import { Constants } from '../namespaces/constants.js';
//import axios from '../../node_modules/axios/index.js';
declare const axios: AxiosStatic;

export const clientGet = axios.create({
    baseURL: Constants.HOME_URL,
    timeout: 10000,
    responseType: 'text'
});

export const clientPost = axios.create({
    baseURL: Constants.HOME_URL,
    timeout: 10000,
    headers: {
        'Content-Type' : 'application-json', 'Accept': 'application/json'
    },
    responseType: 'text'
});