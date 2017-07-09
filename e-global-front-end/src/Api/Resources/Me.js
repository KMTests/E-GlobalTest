import RequestFactory from '../RequestFactory';
import { fetchRequest } from '../api';
import { CLIENT_ME_SUCCESS_ACTION, CLIENT_ME_FAILED_ACTION } from '../../constants';

class MeResource {

    constructor() {
        this.url = '/api/v1/me';
    }

    get() {
        fetchRequest(RequestFactory(this.url), CLIENT_ME_SUCCESS_ACTION, CLIENT_ME_FAILED_ACTION);
    }

}

let meResource = new MeResource();
export default meResource;