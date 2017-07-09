import { EventEmitter } from "events";
import dispatcher from '../dispatcher';
import { refreshToken } from '../Api/api'
import { USER_LOG_IN_FAILED_ACTION, USER_LOG_IN_ACTION, USER_LOGGED_OUT_ACTION } from '../constants';

class SessionStore extends EventEmitter {

    constructor() {
        super();
        let storedUserToken = localStorage.getItem('user_token');
        this.userToken = {};
        if(storedUserToken) {
            storedUserToken = JSON.parse(storedUserToken);
            this.userToken = ('refresh_token' in storedUserToken) ? storedUserToken : {};
        }
        this.loggedIn = (Object.keys(this.userToken).length > 0);
        this.lastError = "";
    }

    isLoggedIn() {
        return this.loggedIn;
    }

    actionsHandler(action) {
        switch (action.type) {
            case(USER_LOG_IN_ACTION):
                this.storeToken(action.body.msg);
                this.emit(USER_LOG_IN_ACTION);
                break;
            case(USER_LOGGED_OUT_ACTION):
                this.loggedIn = false;
                this.userToken = {};
                localStorage.removeItem('user_token');
                this.emit(USER_LOGGED_OUT_ACTION);
                break;
            case(USER_LOG_IN_FAILED_ACTION):
                this.lastError = action.body.msg.error_description;
                this.emit(USER_LOG_IN_FAILED_ACTION);
                break;
        }
    }

    storeToken(token) {
        this.userToken = token;
        this.userToken.expires_at = new Date().getTime() / 1000 + token.expires_in - 5 * 60;
        let userTokenStorage = JSON.parse(localStorage.getItem('user_token'));
        if(userTokenStorage.store) {
            token.store = true;
            localStorage.setItem('user_token', JSON.stringify(token));
        }
        this.loggedIn = true;
    }

    getLastError() {
        return this.lastError;
    }

    getAccessToken() {
        return new Promise((resolve, reject) => {
            if(new Date().getTime() / 1000 >= this.userToken.expires_at) {
                refreshToken(this.userToken.refresh_token).then((jsonResponse) => {
                    this.storeToken(jsonResponse);
                    resolve(this.userToken.access_token);
                });
            } else {
                resolve(this.userToken.access_token);
            }
        });
    }

}

const sessionStore = new SessionStore();
dispatcher.register(sessionStore.actionsHandler.bind(sessionStore));

export default sessionStore;