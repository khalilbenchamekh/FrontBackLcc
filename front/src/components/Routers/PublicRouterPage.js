import React, {Component} from "react";
import {Switch, Route, Link} from "react-router-dom";
import AdminDashboard from "../../components/Admin/AdminDashboard";
import Permissions from "../../components/Admin/permissions";
import businessNature from "../../components/business/natures/index";
import loadNature from "../../components/Loads/natures/index";
import load from "../../components/Loads/loads/index";
import CadastraleConsultion from "../../components/CadastraleConsultation/index";
import GreatConstructionSites from "../../components/GreatConstructionSites/index";
import businessSituation from "../../components/business/situations/index";
import folderTechNature from "../../components/folderTech/natures/index";
import folderTechSituation from "../../components/folderTech/situations/index";
import intermediate from "../../components/CustomerRelationship/intermediate/index";
import clientIntermediate from "../../components/CustomerRelationship/index";
import BusinessFees from "../../components/Fees/BusinessFees/index";
import FolderTechFees from "../../components/Fees/FolderTechFees/index";
import business from "../../components/business/business/index";
import FileManagerComponent from "../FileManager/FileManagerComponent/index";
//import FileManagerComponent from "../syncfusion/FileManager";
import BasicViews from "../../components/React Scheduler/BasicViews";
import Container from "@material-ui/core/Container";
import Dashboard from "../dashboard/Dashboard";
import FactureForm from "../facture/FactureForm";
import client from "../CustomerRelationship/client";
import folderTech from "../folderTech/folderTech";
import MessengerPage from "../Messenger/MessengerPage";
import ProfilePage from "../profile/ProfilePage";
import HomeAdmin from "../HomeAdmin/HomeAdmin";
import SearchPage from "../SearchPage/SearchPage";
import SearchDetails from "../SearchPage/SearchDetails";
import MessagesComponents from "../chat/MessagesComponents";
import LayoutMessagesComponents from "../chat/Layout";
import Logs from "../logs";
import Statistics from "../Statistics";
import StatisticsDetails from "../Statistics/StatisticsDetails";
import NotificationPage from "../Notifications/Views/NotificationPage";
import PrivateRoute from "../../container/privateRoute";

import changes from "../../components/charge/loads/index";
import types from "../../components/charge/natures/index";
import invoiceStatus from "../../components/charge/invoiceStatus/index";

class PublicRouterPage extends Component {
    render() {
        return (
            <Container maxWidth="lg">
                <Switch>
                    <PrivateRoute path="/profile" component={ProfilePage}/>
                    <PrivateRoute path="/messaging" component={LayoutMessagesComponents}/>
                    <PrivateRoute path="/messaging/:id" component={LayoutMessagesComponents}/>
                    <PrivateRoute path="/notifications" component={NotificationPage}/>
                    <PrivateRoute path="/statistics/details" component={StatisticsDetails}/>
                    <PrivateRoute path="/statistics" component={Statistics}/>
                    <PrivateRoute path="/profile" component={ProfilePage}/>
                    <PrivateRoute path="/Charges/Charge" component={changes}/>
                    <PrivateRoute path="/Charges/type" component={types}/>
                    <PrivateRoute path="/Charges/invoiceStatus" component={invoiceStatus}/>
                    <PrivateRoute path='/fileManager'  component={FileManagerComponent}/>
                    <PrivateRoute path='/planing'  component={BasicViews}/>
                    <PrivateRoute path='/consulting'  component={CadastraleConsultion}/>
                    <PrivateRoute path='/load'  component={load}/>
                    <PrivateRoute path='/load/natures' component={loadNature}/>
                    <PrivateRoute path='/sites'  component={GreatConstructionSites}/>
                    <PrivateRoute path='/Permission' component={Permissions}/>
                    <PrivateRoute path='/business/natures' component={businessNature}/>
                    <PrivateRoute path='/business/situations' component={businessSituation}/>
                    <PrivateRoute path='/folderTech/natures' component={folderTechNature}/>
                    <PrivateRoute path='/folderTech/situations' component={folderTechSituation}/>
                    <PrivateRoute path='/customerRelationship/intermediate' component={intermediate}/>
                    <PrivateRoute path='/customerRelationship/client' component={client}/>
                    <PrivateRoute path='/customerRelationship/clientIntermediate' component={clientIntermediate}/>
                    <PrivateRoute path='/business/business' component={business}/>
                    <PrivateRoute path='/BusinessFees' component={BusinessFees}/>
                    <PrivateRoute path='/FolderTechFees' component={FolderTechFees}/>
                    <PrivateRoute path="/home"  component={HomeAdmin}/>
                    <PrivateRoute path="/dashboard"  component={Dashboard}/>
                    <PrivateRoute path="/facture"  component={FactureForm}/>
                    <PrivateRoute path="/folderTech/folderTech"  component={folderTech}/>
                    <PrivateRoute path="/search/details/:entity/:id"  component={SearchDetails}/>
                    <PrivateRoute path="/search"  component={SearchPage}/>
                    <PrivateRoute path="/log"  component={Logs}/>
                    <PrivateRoute path='/' component={AdminDashboard}/>
                </Switch>
            </Container>
        );
    }
}

export default PublicRouterPage;
