import React from 'react';
import {login} from '../Api/api';
import SessionStore from '../Stores/SessionStore';
import { withRouter } from 'react-router-dom';
import { USER_LOG_IN_ACTION, USER_LOG_IN_FAILED_ACTION } from '../constants';

class Login extends React.Component {

    static contextTypes = {
        router: React.PropTypes.object.isRequired
    };

    constructor(props) {
        super(props);
        this.getLoginError = this.getLoginError.bind(this);
        this.redirectOnLogin = this.redirectOnLogin.bind(this);
        this.state = {
            email: '',
            password: '',
            rememberMe: true,
            error_msg: ''
        };
    };

    componentWillMount() {
        SessionStore.on(USER_LOG_IN_FAILED_ACTION, this.getLoginError);
        SessionStore.on(USER_LOG_IN_ACTION, this.redirectOnLogin);
    }

    componentWillUnmount() {
        SessionStore.removeListener(USER_LOG_IN_FAILED_ACTION, this.getLoginError);
        SessionStore.removeListener(USER_LOG_IN_ACTION, this.redirectOnLogin);
    }

    getLoginError() {
        this.setState({
            error_msg: SessionStore.getLastError()
        });
    }

    redirectOnLogin() {
        this.props.history.push('/secured');
    }

    handleEmailChange(e) {
        this.setState({email: e.target.value});
    };

    handlePasswordChange(e) {
        this.setState({password: e.target.value});
    };

    handleRememberChange(e) {
        this.setState({rememberMe: !this.state.rememberMe});
    };

    login() {
        login(this.state.email, this.state.password, this.state.rememberMe);
    };

    render() {
        return (
            <div className="form-horizontal container">
                <div className="col-sm-offset-2 col-sm-10">
                    {this.state.error_msg}
                </div>
                <div className="form-group">
                    <label htmlFor="inputEmail3" className="col-sm-2 control-label">Email</label>
                    <div className="col-sm-10">
                        <input onChange={this.handleEmailChange.bind(this)} type="email" className="form-control" id="inputEmail3" placeholder="Email"/>
                    </div>
                </div>
                <div className="form-group">
                    <label htmlFor="inputPassword3" className="col-sm-2 control-label">Password</label>
                    <div className="col-sm-10">
                        <input onChange={this.handlePasswordChange.bind(this)} type="password" className="form-control" id="inputPassword3" placeholder="Password"/>
                    </div>
                </div>
                <div className="form-group">
                    <div className="col-sm-offset-2 col-sm-10">
                        <div className="checkbox">
                            <label>
                                <input onChange={this.handleRememberChange.bind(this)} type="checkbox"/> Remember me
                            </label>
                        </div>
                    </div>
                </div>
                <div className="form-group">
                    <div className="col-sm-offset-2 col-sm-10">
                        <button type="submit" onClick={this.login.bind(this)} className="btn btn-default">Sign in</button>
                    </div>
                </div>
            </div>
        )
    }
}

export default withRouter(Login);
