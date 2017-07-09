import React from 'react';
import { withRouter } from 'react-router-dom';
import ClientStore from '../Stores/ClientStore';
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
import MeResource from '../Api/Resources/Me';
import ClientAddressesResource from '../Api/Resources/ClientAddresses'

class ClientProfile extends React.Component {

    constructor(props) {
        super(props);
        this.getMeResponseError = this.getMeResponseError.bind(this);
        this.getMeResponseHandler = this.getMeResponseHandler.bind(this);
        this.deleteAddressSuccess = this.deleteAddressSuccess.bind(this);
        this.deleteAddressFailed = this.deleteAddressFailed.bind(this);
        this.createNewAddressSuccess = this.createNewAddressSuccess.bind(this);
        this.createNewAddressFailed = this.createNewAddressFailed.bind(this);
        this.editAddressSuccess = this.editAddressSuccess.bind(this);
        MeResource.get();
    }

    updateClient(client = null) {
        if(!client) {
            client = {
                'client_id': null,
                'first_name': 'loading',
                'last_name': 'loading',
                'shipping_addresses': []
            }
        }
        this.setState({'client': client});
    }

    componentWillMount() {
        ClientStore.on(CLIENT_ME_FAILED_ACTION, this.getMeResponseError);
        ClientStore.on(CLIENT_ME_SUCCESS_ACTION, this.getMeResponseHandler);
        ClientStore.on(CLIENT_ADDRESS_DELETED_ACTION, this.deleteAddressSuccess);
        ClientStore.on(CLIENT_ADDRESS_DELETE_FAILED_ACTION, this.deleteAddressFailed);
        ClientStore.on(CLIENT_NEW_ADDRESS_ACTION, this.createNewAddressSuccess);
        ClientStore.on(CLIENT_NEW_ADDRESS_FAILED_ACTION, this.createNewAddressFailed);
        ClientStore.on(CLIENT_UPDATE_ADDRESS_ACTION, this.editAddressSuccess);
        ClientStore.on(CLIENT_UPDATE_ADDRESS_FAILED_ACTION, this.createNewAddressFailed);
        this.setState({
            'error_text': null,
            'open_form': false,
            'form_data': {
                'country': '',
                'city': '',
                'zipcode': '',
                'street': '',
                'default': false,
                'id': null
            },
            'form_errors': {
                'country': [],
                'city': [],
                'zipcode': [],
                'street': [],
                'default': []
            }
        });
        this.updateClient();
    }

    componentWillUnmount() {
        ClientStore.removeListener(CLIENT_ME_FAILED_ACTION, this.getMeResponseError);
        ClientStore.removeListener(CLIENT_ME_SUCCESS_ACTION, this.getMeResponseHandler);
        ClientStore.removeListener(CLIENT_ADDRESS_DELETED_ACTION, this.deleteAddressSuccess);
        ClientStore.removeListener(CLIENT_ADDRESS_DELETE_FAILED_ACTION, this.deleteAddressFailed);
        ClientStore.removeListener(CLIENT_NEW_ADDRESS_ACTION, this.createNewAddressSuccess);
        ClientStore.removeListener(CLIENT_NEW_ADDRESS_FAILED_ACTION, this.createNewAddressFailed);
        ClientStore.removeListener(CLIENT_UPDATE_ADDRESS_ACTION, this.editAddressSuccess);
        ClientStore.removeListener(CLIENT_UPDATE_ADDRESS_FAILED_ACTION, this.createNewAddressFailed);
    }

    getMeResponseError() {
        console.log("Error");
    }

    getMeResponseHandler() {
        this.updateClient(ClientStore.getClient());
    }

    deleteAddressSuccess() {
        MeResource.get();
    }

    deleteAddressFailed() {
        this.setState({'error_text': ClientStore.getAddressErrorText()});
    }

    createNewAddressSuccess() {
        this.setState({'open_form': false});
        MeResource.get();
    }

    createNewAddressFailed() {
        let errors = ClientStore.getValidationErrors();
        let form_errors = {
            'country': [],
            'city': [],
            'zipcode': [],
            'street': [],
            'default': []
        };
        for (let key in errors) {
            if (errors.hasOwnProperty(key)) {
                form_errors[key] = errors[key];
            }
        }
        this.setState({
            'error_text': ClientStore.getAddressErrorText(),
            'form_errors': form_errors
        });
    }

    deleteAddress(e) {
        ClientAddressesResource.remove(this.state.client.client_id, e.target.dataset.id);
    }

    editAddress(e) {
        let shippingAddress = {};
        this.state.client.shipping_addresses.map(function(address) {
            if(address.id.toString() === e.target.dataset.id) {
                shippingAddress = address;
            }
        });
        this.setState({
            'form_data': shippingAddress,
            'open_form': true
        });
    }

    editAddressSuccess() {
        this.setState({'open_form': false});
        MeResource.get();
    }

    createNewAddress(e) {
        this.setState({
            'error_text': '',
            'form_errors': {
                'country': [],
                'city': [],
                'zipcode': [],
                'street': [],
                'default': []
            }
        });
        if(e.target.dataset.id) {
            ClientAddressesResource.update(this.state.client.client_id, e.target.dataset.id, this.state.form_data)
        } else {
            ClientAddressesResource.create(this.state.client.client_id, this.state.form_data);
        }
    }

    createNewAddressForm(e) {
        this.setState({'open_form': true});
    }

    cancelNewAddress(e) {
        this.setState({'open_form': false});
    }

    handleFormChange(e) {
        let form_data = this.state.form_data;
        if(e.target.id === 'default') {
            form_data[e.target.id] = e.target.checked;
        } else {
            form_data[e.target.id] = e.target.value;
        }
        this.setState({'form_data': form_data});
    }

    renderForm() {
        return (
            <div className="header clearfix form-horizontal">
                { this.state.form_errors.country.map((error, i) => {
                    return <div key={i} className="danger col-sm-offset-2 col-sm-10">{ error }</div>
                }) }
                <div className="form-group">
                    <label htmlFor="country" className="col-sm-2 control-label">Country: </label>
                    <div className="col-sm-10">
                        <input type="text" value={this.state.form_data.country} className="form-control" id="country"
                               onChange={this.handleFormChange.bind(this)} placeholder="Country"/>
                    </div>
                </div>
                { this.state.form_errors.city.map((error, i) => {
                    return <div key={i} className="danger col-sm-offset-2 col-sm-10">{ error }</div>
                }) }
                <div className="form-group">
                    <label htmlFor="city" className="col-sm-2 control-label">City: </label>
                    <div className="col-sm-10">
                        <input type="text" value={this.state.form_data.city} className="form-control" id="city"
                               onChange={this.handleFormChange.bind(this)} placeholder="City"/>
                    </div>
                </div>
                { this.state.form_errors.zipcode.map((error, i) => {
                    return <div key={i} className="danger col-sm-offset-2 col-sm-10">{ error }</div>
                }) }
                <div className="form-group">
                    <label htmlFor="zipcode" className="col-sm-2 control-label">Zipcode: </label>
                    <div className="col-sm-10">
                        <input type="text" value={this.state.form_data.zipcode} className="form-control" id="zipcode"
                               onChange={this.handleFormChange.bind(this)} placeholder="Zipcode"/>
                    </div>
                </div>
                { this.state.form_errors.street.map((error, i) => {
                    return <div key={i} className="danger col-sm-offset-2 col-sm-10">{ error }</div>
                }) }
                <div className="form-group">
                    <label htmlFor="street" className="col-sm-2 control-label">Street: </label>
                    <div className="col-sm-10">
                        <input type="text" value={this.state.form_data.street} className="form-control" id="street"
                               onChange={this.handleFormChange.bind(this)} placeholder="Street"/>
                    </div>
                </div>
                { this.state.form_errors.default.map((error, i) => {
                    return <div key={i} className="danger col-sm-offset-2 col-sm-10">{ error }</div>
                }) }
                <div className="form-group">
                    <label htmlFor="default" className="col-sm-2 control-label">Default: </label>
                    <div className="col-sm-10">
                        <input onChange={this.handleFormChange.bind(this)} type="checkbox" id="default"
                               defaultChecked={this.state.form_data.default}/>
                    </div>
                </div>
                <button onClick={this.cancelNewAddress.bind(this)} className="btn btn-danger pull-right">Cancel</button>
                <button onClick={this.createNewAddress.bind(this)} data-id={this.state.form_data.id}
                        className="btn btn-success pull-right">
                    Save
                </button>
            </div>
        )
    }

    render() {
        return (
            <div>
                <p>{ this.state.error_text }</p>
                { this.state.open_form && this.renderForm() }
                <div className="row">
                    <div className="col-md-6">
                        <p>{this.state.client.first_name} {this.state.client.last_name} (ID={ this.state.client.client_id })</p>
                    </div>
                    <div className="col-md-6">
                        { (this.state.client.client_id && this.state.client.shipping_addresses.length < 3) &&
                            <button onClick={this.createNewAddressForm.bind(this)} className="pull-right btn btn-success">
                                New address
                            </button>
                        }
                    </div>
                </div>
                <hr/>
                <div className="table-responsive">
                    <table className="table table-striped">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Country</th>
                            <th>City</th>
                            <th>ZipCode</th>
                            <th>Street</th>
                            <th>Default</th>
                            <th>Delete</th>
                            <th>Edit</th>
                        </tr>
                        </thead>
                        <tbody>
                        { this.state.client.shipping_addresses.map((shippingAddress) => {
                            return (
                                <tr key={shippingAddress.id}>
                                    <td>{ shippingAddress.id }</td>
                                    <td>{ shippingAddress.country }</td>
                                    <td>{ shippingAddress.city }</td>
                                    <td>{ shippingAddress.zipcode }</td>
                                    <td>{ shippingAddress.street }</td>
                                    <td>{ shippingAddress.default.toString() }</td>
                                    <td>
                                    { (shippingAddress.default === false) &&
                                        <button data-id={shippingAddress.id} onClick={this.deleteAddress.bind(this)}
                                                className="btn btn-danger">
                                            Delete
                                        </button>
                                    }
                                    </td>
                                    <td>
                                        <button data-id={shippingAddress.id} onClick={this.editAddress.bind(this)}
                                                className="btn btn-primary">
                                            Edit
                                        </button>
                                    </td>
                                </tr>
                            );
                        }) }
                        </tbody>
                    </table>
                </div>
            </div>
        );
    }

}

export default withRouter(ClientProfile);