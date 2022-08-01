import React from 'react';
import {Redirect, Route} from 'react-router-dom';
import {isOwner} from "../utils/cookies";

const PrivateRoute = ({isOwner: bool, component: Component, ...rest}) => (
    <Route {...rest} render={props => (
        isOwner() !== null ? (
            <Component {...props} />
        ) : (
            <Redirect to={{
                pathname: '/',
                state: {from: props.location}
            }}
            />
        )
    )}/>
);

export default PrivateRoute;
