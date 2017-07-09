import { EventEmitter } from "events";
import dispatcher from '../dispatcher';
import {
    CLIENT_ME_FAILED_ACTION,
    CLIENT_ME_SUCCESS_ACTION,
    CLIENT_ADDRESS_DELETED_ACTION,
    CLIENT_ADDRESS_DELETE_FAILED_ACTION,
    CLIENT_NEW_ADDRESS_ACTION,
    CLIENT_NEW_ADDRESS_FAILED_ACTION,
    CLIENT_UPDATE_ADDRESS_ACTION,
    CLIENT_UPDATE_ADDRESS_FAILED_ACTION
} from '../constants';

class ClientStore extends EventEmitter {

    constructor() {
        super();
        this.client = null;
        this.addressErrorCode = null;
        this.addressErrorMsg = null;
        this.addressValidationErrors = null;
    }

    actionsHandler(action) {
        switch (action.type) {
            case CLIENT_ME_FAILED_ACTION:
                this.emit(CLIENT_ME_FAILED_ACTION);
                break;
            case CLIENT_ME_SUCCESS_ACTION:
                this.client = action.body.msg;
                this.emit(CLIENT_ME_SUCCESS_ACTION);
                break;
            case CLIENT_ADDRESS_DELETED_ACTION:
                this.emit(CLIENT_ADDRESS_DELETED_ACTION);
                break;
            case CLIENT_ADDRESS_DELETE_FAILED_ACTION:
                this.addressErrorCode = action.body.msg.error_code;
                this.addressErrorMsg = action.body.msg.error_message;
                this.emit(CLIENT_ADDRESS_DELETE_FAILED_ACTION)
                break;
            case CLIENT_NEW_ADDRESS_ACTION:
                this.emit(CLIENT_NEW_ADDRESS_ACTION);
                break;
            case CLIENT_NEW_ADDRESS_FAILED_ACTION:
                this.addressErrorCode = action.body.msg.error_code;
                this.addressErrorMsg = action.body.msg.error_message;
                this.addressValidationErrors = action.body.msg.errors;
                this.emit(CLIENT_NEW_ADDRESS_FAILED_ACTION);
                break;
            case CLIENT_UPDATE_ADDRESS_ACTION:
                this.emit(CLIENT_UPDATE_ADDRESS_ACTION);
                break;
            case CLIENT_UPDATE_ADDRESS_FAILED_ACTION:
                this.addressErrorCode = action.body.msg.error_code;
                this.addressErrorMsg = action.body.msg.error_message;
                this.addressValidationErrors = action.body.msg.errors;
                this.emit(CLIENT_UPDATE_ADDRESS_FAILED_ACTION);
                break;
        }
    }

    isAdmin() {
        if(!this.client) {
            return false;
        }
        return this.client.is_admin;
    }

    getClient() {
        return this.client;
    }

    getAddressErrorText() {
        return this.addressErrorCode + ': ' + this.addressErrorMsg;
    }

    getValidationErrors() {
        return this.addressValidationErrors;
    }

}

const clientStore = new ClientStore();
dispatcher.register(clientStore.actionsHandler.bind(clientStore));

export default clientStore;