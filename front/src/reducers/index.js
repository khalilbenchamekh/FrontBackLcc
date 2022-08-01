import { combineReducers } from 'redux';
import register from './registerReducer';
import login from './loginReducer';
import adminRes from './adminResourcesReducer';
import refreshToken from './refreshTokenReducer';
import businessNatures from './crud/businessNatureReducer';
import loadNature from './crud/loadNatureReducer';
import businessSituations from './crud/businessSituationReducer';
import folderTechNatures from './crud/folderTechNatureReducer';
import folderTechSituations from './crud/folderTechSituationReducer';
import clients from './crud/clientReducer';
import intermediates from './crud/intermediateReducer';
import suggestions from './AutoComplete/autoCompleteReducer';
import business from './crud/businessReducer';
import cadastraux from './crud/cadastraleConsultationReducer';
import loads from './crud/loadsReducer';
import constructionSites from './crud/greatConstructionSitesReducer';
import employees from './crud/employeeReducer';
import feesBusiness from './crud/feesBusinessReducer';
import feesFolderTech from './crud/feesFolderTechReducer';
import missions from './crud/missionReducer';
import conversations from './messagerie/conversationReducer';
import auth from "./messagerie/auth";
import select from "./select/selectReducer";
import chats from "./messagerie/chats";
import services from "./messagerie/services";
import messages from "./messagerie/messages";
import locations from "./dashboard/locationReducer";
import DatefilterReducer from "./DateAirbnb/DateFilterReducer";
import searchReducer from './crud/searchReducer';
import folderTech from './crud/folderTechReducer';

import charges from './crud/chargeReducer';
import chargeTypes from './crud/chargeTypeReducer';
import invoiceStatus from './crud/invoiceStatusReducer';

import logReducer from './crud/logReducer';
import statisticsReducer from './crud/statisticsReducer';
import SpinnerReducer from './SpinnerReducer';
import notificationsReducer from './notificationsReducer';

const rootReducer = combineReducers({
    register, login, adminRes, refreshToken,
    businessNatures,
    businessSituations,
    folderTechNatures,
    intermediates,
    clients,
    folderTechSituations,
    suggestions,
    business,
    conversations,
    auth,
    chats,
    locations,
    messages,
    services,
    DatefilterReducer,
    loadNature,
    constructionSites,
    invoiceStatus,
    chargeTypes,
    charges,
    employees,
    loads,
    feesBusiness,
    feesFolderTech,
    cadastraux, select,
    folderTech,
    missions,
    search: searchReducer,
    logs: logReducer,
    statistics: statisticsReducer,
    spinner: SpinnerReducer,
    notifications: notificationsReducer
});

export default rootReducer;
