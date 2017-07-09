import React from 'react';
import { logout } from '../Api/api'
import { withRouter } from 'react-router-dom';

class Logout extends React.Component {

    componentWillMount() {
        logout();
        this.props.history.push('/login');
    }

    render() {
        return null;
    }

}

export default withRouter(Logout);