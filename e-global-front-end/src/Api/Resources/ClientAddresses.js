import RequestFactory from '../RequestFactory';
import { fetchRequest } from '../api';
import {
    CLIENT_ADDRESS_DELETE_FAILED_ACTION,
    CLIENT_ADDRESS_DELETED_ACTION,
    CLIENT_NEW_ADDRESS_ACTION,
    CLIENT_NEW_ADDRESS_FAILED_ACTION,
    CLIENT_UPDATE_ADDRESS_ACTION,
    CLIENT_UPDATE_ADDRESS_FAILED_ACTION
} from '../../constants'

class ClientAddressesResource {

    constructor() {
        this.url = '/api/v1/clients/{client_id}/addresses';
    }

    remove(client_id, address_id) {
        let request = RequestFactory(this.url.replace('{client_id}', client_id) + '/' + address_id, true, 'DELETE');
        fetchRequest(request, CLIENT_ADDRESS_DELETED_ACTION, CLIENT_ADDRESS_DELETE_FAILED_ACTION);
    }

    create(client_id, address_data) {
        let request = RequestFactory(this.url.replace('{client_id}', client_id), true, 'POST');
        fetchRequest(request.setJsonBody(address_data), CLIENT_NEW_ADDRESS_ACTION, CLIENT_NEW_ADDRESS_FAILED_ACTION);
    }

    update(client_id, address_id, address_data) {
        let request = RequestFactory(this.url.replace('{client_id}', client_id) + '/' + address_id, true, 'PUT');
        fetchRequest(request.setJsonBody(address_data), CLIENT_UPDATE_ADDRESS_ACTION, CLIENT_UPDATE_ADDRESS_FAILED_ACTION);
    }

}

let clientAddressesResource = new ClientAddressesResource();
export default clientAddressesResource;