import React, {Component} from "react";
import {Switch, Route, Link} from "react-router-dom";

import Container from "@material-ui/core/Container";
import HomeAdmin from "../HomeAdmin/HomeAdmin";
import employees from "../employee/index";
import Permissions from "../../components/Admin/permissions";
import PrivateRoute from "../../container/privateRoute";

class AdminRouterPage extends Component {
    render() {
        const {classes} = this.props;
        return (
            <Container maxWidth="lg">
                <Switch>
                    <PrivateRoute path="/admin/Permission" isOwner={true} component={Permissions}/>
                    <PrivateRoute path="/admin/employees" isOwner={true} component={employees}/>
                </Switch>
            </Container>
        );
    }
}

export default AdminRouterPage;
