import React from 'react';
import ClientProfile from '../Pages/ClientProfile';
import Header from './Header';


export default class Layout extends React.Component {

    constructor(props) {
        super(props);
        this.status = {
            loading: false
        }
    }

    render() {
        const SecuredRoute = this.props.guard;
        return (
            <div className="container">
                <Header securedRoute={SecuredRoute}/>
                <SecuredRoute path="/secured" exact component={ClientProfile}></SecuredRoute>
            </div>
        )
    }



}