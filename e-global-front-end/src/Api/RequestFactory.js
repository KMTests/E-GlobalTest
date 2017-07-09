import config from '../config';
import SessionStore from '../Stores/SessionStore';

class Request {

    constructor(resourcePath, addToken = true, method = 'GET') {
        this.requestReady = true;
        this.url = config.api_base + resourcePath;
        this.payload = {
            headers: {
                'Content-Type': 'application/json'
            },
            method: method
        };
        addToken ? this.addToken() : null;
    }

    setMethod(method) {
        this.payload.method = method;
        return this;
    }

    setJsonBody(body) {
        this.payload.body = JSON.stringify(body);
        return this;
    }

    addToken() {
        this.requestReady = false;
        SessionStore.getAccessToken().then((token) => {
            this.payload.headers.Authorization = 'Bearer ' + token;
            this.requestReady = true;
        });
        return this;
    }

}

export default function createRequest(resourcePath, addToken = true, method = 'GET') {
    return new Request(resourcePath, addToken, method);
}