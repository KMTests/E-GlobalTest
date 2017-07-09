import config from '../config';
import RequestFactory from './RequestFactory';
import dispatcher from '../dispatcher';
import {USER_LOG_IN_ACTION, USER_LOG_IN_FAILED_ACTION, USER_LOGGED_OUT_ACTION} from '../constants';

require('isomorphic-fetch');
require('es6-promise').polyfill();

export function login(username, password, remember) {
    localStorage.setItem('user_token', JSON.stringify({store: remember}));
    let request = RequestFactory('/oauth/v2/token', false, 'POST');
    request.setJsonBody({
        grant_type: 'password',
        client_id: config.api_client_id,
        client_secret: config.api_client_secret,
        username: username,
        password: password
    });
    fetchRequest(request, USER_LOG_IN_ACTION, USER_LOG_IN_FAILED_ACTION);
}

export function logout() {
    dispatcher.dispatch({'type': USER_LOGGED_OUT_ACTION});
}

export function refreshToken(refreshToken) {
    let request = RequestFactory('/oauth/v2/token', false, 'POST');
    request.setJsonBody({
        grant_type: 'refresh_token',
        client_id: config.client_id,
        client_secret: config.client_secret,
        refresh_token: refreshToken
    });
    return fetch(request.url, request.payload).then(function (response) {
        return response.json();
    });
}

export function fetchRequest(request, successType, errorType) {
    if(request.requestReady) {
        let statusCode = 0;
        fetch(request.url, request.payload).then(function (response) {
            statusCode = response.status;
            if(statusCode === 204) {
                return [];
            }
            return response.json();
        }).then(function (responseJsonBody) {
            let type = (statusCode >= 400) ? errorType : successType;
            dispatcher.dispatch({
                'type': type,
                'body': {
                    'msg': responseJsonBody,
                    'status_code': statusCode
                }
            });
        });
    } else {
        window.setTimeout(function () {
            fetchRequest(request, successType, errorType);
        }, 100);
    }
}