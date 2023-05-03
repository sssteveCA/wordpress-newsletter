//import axios from '../../node_modules/axios/index';
import axios from 'axios';
import { Constants } from '../namespaces/constants';
//import axios from '../../node_modules/axios/index';

export const clientGet = axios.create({
    baseURL: Constants.HOME_URL,
    timeout: 20000,
    responseType: 'text'
});

export const clientPost = axios.create({
    baseURL: Constants.HOME_URL,
    timeout: 20000,
    headers: {
        'Content-Type' : 'application-json', 'Accept': 'application/json'
    },
    responseType: 'text'
});