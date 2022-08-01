import React from 'react';
import { Redirect, Route } from 'react-router-dom';
import { checkCookie } from '../utils/cookies';
import {owner} from "../Constansts/file";






const AdminRoute = ({ component: Component, ...rest }) => (
    <Route { ...rest } render={props => (
       checkCookie() ===owner ? (
            <Component { ...props } />
        ) : (
            <Redirect to={{
                pathname: '/',
                state: { from: props.location }
            }}
            />
        )
    )} />
);

export default AdminRoute;
