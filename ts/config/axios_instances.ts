import axios from '../../node_modules/axios/index';
import { Constants } from '../namespaces/constants';

export const clientPost = axios.create({
    baseURL: Constants.HOME_URL,
    timeout: 5000,
    headers: {
        'Content-Type' : 'application-json', 'Accept': 'application/json'
    },
    responseType: 'text'
});