import React, {Component} from "react";
import {BrowserRouter, Route, Switch} from "react-router-dom";
import LoginPage from "../components/loginPage";
import RegisterPage from "../components/registerPage";
import {withStyles} from "@material-ui/core/styles";
import {connect} from "react-redux";
import {compose} from "recompose";

import LoadingPopUp from "../components/Shared/LoadingPopUp";
import AdminLayout from "../components/Shared/Layouts/AdminLayout";
import PublicLayout from "../components/Shared/Layouts/PublicLayout";
import sprintf from 'sprintf';
import _ from 'underscore';
import {mapboxGetCoordinateWithLatAndLng, mapboxZoom, PositionIfDenide} from "../Constansts/map";
import {Redirect} from "react-router";
import Scrollbar from "react-scrollbars-custom";
//import FileManagerComponent from "../components/FileManager/FileManagerComponent";
import FileManagerComponent from "../components/syncfusion/FileManager";
import Pusher from "pusher-js"
import {checkCookie, getCookie, getUser} from "../utils/cookies";
import Echo from "laravel-echo";
import socketio from "socket.io-client";
import {messageRecievedAction, setUserAction} from "../actions/messagerie/messagerieActions";
import {
    brodcaster,
    PUSHER_APP_ID,
    cluster,
    PUSHER_APP_KEY,
    PUSHER_APP_SECRET,
    encrypted, forceTLS
} from "../Constansts/appconstant";
import {authEndpoint, Url} from "../Env/env";
import {owner} from "../Constansts/file";
import {checkForTokenAction} from "../actions/authenticationActions";
import PrivateRoute from "./privateRoute";
import {countDownRecieved, logsRecieved} from "../actions/notificationActions";

const styles = theme => ({
    root: {
        position: 'relative',
        display: 'flex',
        width: '100%',
        height: '100%',
        backgroundColor: theme.palette.background.default,
    },
});

class App extends Component {
    async componentDidMount() {
        try {

            let successCallback = async (position) => {
                const {longitude, latitude} = position.coords;
                let geoCoordinate = await this.getAddress({longitude: longitude, latitude: latitude});
                let city = [];
                city.push({city: geoCoordinate.city, lat: geoCoordinate.longitude, lng: geoCoordinate.latitude});
                // this.props.dispatch({
                //     type: "SET_POSITION",
                //     adr: geoCoordinate
                // });
                console.log("i'm tracking you!");
            };
            navigator.geolocation.getCurrentPosition(successCallback, positionError => {
                let watchId = navigator.geolocation.watchPosition(async position => {
                        await successCallback(position);
                        navigator.geolocation.clearWatch(watchId);
                    },
                    async (error) => {
                        if (error.code === error.PERMISSION_DENIED) {
                            let ipResponse = await fetch(PositionIfDenide);
                            let ip = await ipResponse.json();
                            let city = [];
                            city.push({city: ip.city, lat: ip.longitude, lng: ip.latitude});
                            // this.props.dispatch({
                            //     type: "SET_POSITION",
                            //     adr: {longitude: ip.longitude, latitude: ip.latitude, city: ip.city, zoom: mapboxZoom}
                            // });

                            console.log("you denied me :-(");
                            navigator.geolocation.clearWatch(watchId);
                        }
                    });

            });


        } catch (e) {
            console.log("From Try you denied me :-(");
        }
    }

    async getAddress(request) {
        let result = {};
        if (request.latitude && request.longitude) {
            let url = sprintf(mapboxGetCoordinateWithLatAndLng, request.longitude, request.latitude);
            let response = await fetch(url);
            let geoCoordinate = await response.json();
            _.each(geoCoordinate.features, (feature) => {
                if (feature.place_type[0] === "place") {
                    result = {
                        latitude: feature.center[1],
                        longitude: feature.center[0],
                        city: feature.text,
                        zoom: mapboxZoom
                    }
                }
            });
        } else {
            let geoIpResponse = await fetch(PositionIfDenide);
            let geoIp = await geoIpResponse.json();
            result = geoIp;
        }
        return result;
    }

    componentWillMount() {
        let token = this.props.token === '' ? getCookie('token') : this.props.token;
        this.props.checkForTokenAction();

        if (token) {
            let user = getUser();
            let user_id = user.id;
            let echo = {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                    'Access-Control-Allow-Origin': '*',
                    'Content-Type': 'application/json',
                    Authorization: `Bearer ${token}`,
                },
                wsHost: window.location.hostname,
                wsPort: 6001,
                disableStats: true,
                broadcaster: brodcaster,
                host: window.location.hostname + ':6001'
            };
            if (brodcaster === 'pusher') {
                // window.Pusher = Pusher;
                echo.auth = {
                    headers: {
                        Authorization: `Bearer ${token}`,
                        Accept: 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'Access-Control-Allow-Origin': '*',
                    },
                };
                echo.key = PUSHER_APP_KEY;
                echo.encrypted = encrypted;
                echo.cluster = cluster;
                echo.authEndpoint = Url + authEndpoint;
            } else {
                echo.client = socketio;
            }
            window.Echo = new Echo(echo).private(`App.User.${user_id}`).listen('.newMessage', e => {
                this.props.messageRecievedAction(e);
            });
            if (checkCookie() === owner) {
                window.Echo = new Echo(echo).private(`countDown`).listen('.newCountDown', e => {

                    let collection =e.collection;
                    if(collection){
                        this.props.countDownRecieved(collection);
                    }

                });
                window.Echo = new Echo(echo).private(`logs`).listen('.newLogs', e => {
                    let logs = e.logActivity;
                    if (logs) {
                        this.props.logsRecieved(logs);
                    }

                });
            }


        }
    }

    render() {
        return (
            <>
             {/* THIS ONE IS A VALID COMMENT */}
                <LoadingPopUp/>
                <BrowserRouter>
                    <Scrollbar style={{width: "100%", height: "96.5vh"}}>
                        <Switch>
                            <Route path="/" exact={true} component={LoginPage}/>
                            <Route path="/login" component={LoginPage}/>
                            <Route path="/register" component={RegisterPage}/>
                            <Route path="/admin" component={AdminLayout}/>
                            <PrivateRoute path='/fileManager' component={FileManagerComponent}/>
                            <Route path="" component={PublicLayout}/>
                            <Redirect to="/"/>
                        </Switch>
                    </Scrollbar>
                </BrowserRouter>
            </>

        );
    }
}

function mapStateToProps(state) {
    return {
        token: state.login.token,
        adr: state.locations.adr,
    };
}

const mapDispatchToProps = {
    checkForTokenAction,
    messageRecievedAction,
    logsRecieved, countDownRecieved
};

export default compose(
    withStyles(styles, {
        name: "App"
    }),
    connect(mapStateToProps, mapDispatchToProps)
)(App);

