import React from 'react';
import ReactDOM from 'react-dom';
import { HashRouter as Router, Route, Redirect } from 'react-router-dom';
import SessionStore from './Stores/SessionStore'
import registerServiceWorker from './registerServiceWorker';
import Layout from './Components/Layout';
import Login from './Pages/Login';

const SecuredRoute = ({ component: Component, ...rest }) => (
    <Route {...rest} render={props => (
        SessionStore.isLoggedIn() ? (
            <Component {...props}/>
        ) : (
            <Redirect to={{
                pathname: '/login',
                state: { from: props.location }
            }}/>
        )
    )}/>
);

let LayoutWrapper = React.createClass({
    render: function () {
        return (
            <Layout guard={SecuredRoute} />
        );
    }
});

ReactDOM.render(
    <div>
        <Router>
            <div>
                <Route path="/"><Redirect to={{ pathname: 'secured' }}/></Route>
                <Route path="/login" component={Login}></Route>
                <SecuredRoute component={LayoutWrapper} path="/secured"></SecuredRoute>
            </div>
        </Router>
    </div>,
    document.getElementById('root')
);

registerServiceWorker();
