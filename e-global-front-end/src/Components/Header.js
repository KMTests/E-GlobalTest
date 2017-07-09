import React from 'react';
import Logout from '../Pages/Logout';

class Header extends React.Component {

    render() {
        const SecuredRoute = this.props.securedRoute;
        return (
            <div className="header clearfix">
                <nav>
                    <ul className="nav nav-pills pull-right">
                        <SecuredRoute path="/secured/logout" component={Logout}></SecuredRoute>
                        <li role="presentation" className="active"><a href="#/secured/logout">Logout</a></li>
                    </ul>
                </nav>
                <h3 className="text-muted">E-Global test</h3>
            </div>
        )
    }

}

Header.contextTypes = {
    router: React.PropTypes.object,
    location: React.PropTypes.object
};

export default Header;

