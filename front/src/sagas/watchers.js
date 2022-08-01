import { takeLatest } from 'redux-saga/effects';
import {
  registerSaga,
  loginSaga,
  checkIfAuthenticatedSaga,
  getImageProfile,
  setImageProfileSaga, setImageProfileFromStorageSaga
} from './authenticationSaga';

import * as types from '../actions';
import {
  getAutoCompleteSaga,
  getRouteToProtectSaga, getSatitstiquesSaga,
  getUsersWithPermissionsSaga,
  setUsersWithPermissionsSaga
} from "./adminResource";
import {
  addBusinessNaturesSaga,
  addMultiBusinessNaturesSaga, deleteBusinessNaturesSaga, getBusinessNaturesSaga,
  updateBusinessNaturesSaga
} from "./crud/business/natures";
import {
  addBusinessSituationsSaga, addMultiBusinessSituationsSaga, deleteBusinessSituationsSaga,
  getBusinessSituationsSaga,
  updateBusinessSituationsSaga
} from "./crud/business/situations";
import {
  addFolderTechSituationsSaga, addMultiFolderTechSituationsSaga, deleteFolderTechSituationsSaga,
  getFolderTechSituationsSaga,
  updateFolderTechSituationsSaga
} from "./crud/folderTech/situations";
import {
  addFolderTechNaturesSaga, addMultiFolderTechNaturesSaga, deleteFolderTechNaturesSaga,
  getFolderTechNaturesSaga,
  updateFolderTechNaturesSaga
} from "./crud/folderTech/natures";
import {
  addClientSaga, addClientsForSelectSaga,
  addMultiClientSaga,
  deleteClientSaga, getClientSaga,
  updateClientSaga
} from "./crud/customerRelationShip/client";
import {
  addIntermediatesSaga, addMultiIntermediatesSaga, deleteIntermediatesSaga,
  getIntermediatesSaga,
  updateIntermediatesSaga
} from "./crud/customerRelationShip/intermediate";
import {
  addBusinessSaga,
  addMultiBusinessSaga,
  deleteBusinessSaga,
  getBusinessSaga,
  updateBusinessSaga
} from "./crud/business/business";
import {
  downloadFileFromSaga,
  loadConversationsSaga,
  loadMessagesSaga,
  loadPreviousMessagesSaga,
  markAsReadSaga, messageRecievedSaga,
  sendMessageSaga, setUserSaga
} from "./messagerie/messagerieSaga";
import { getLocationsSaga } from "./mapBox/mapBoxSaga";
import { addMissionsSaga, deleteMissionsSaga, getMissionsSaga, updateMissionsSaga } from "./crud/missions/mission";
import {
  addMultiCadastraleConsultationSaga,
  getCadastraleConsultationSaga
} from "./crud/cadastraleConsultation/cadastraleConsultationSaga";
import {
  addgreatConstructionSitesSaga,
  deletegreatConstructionSitesSaga,
  getDatailsGreatConstructionSiteSaga,
  getgreatConstructionSitesSaga,
  getSatitstiquesGreatConstructionSiteSaga,
  updategreatConstructionSitesSaga
} from "./crud/getgreatConstructionSites/getgreatConstructionSitesSaga";
import {
  addLoadsSaga,
  deleteLoadsSaga,
  getLoadsSaga,
  getSatitstiquesLoadSaga,
  updateLoadsSaga
} from "./crud/load/loadSaga";
import {
  getAllocatedBrigadesSaga, getBusinessNaturesByIdSaga, getBusinessSituationByIdSaga,
  getClientByIdSaga, getFolderNaturesByNameSaga, getFolderSituationByIdSaga, getIntermediatesByIdSaga,
  getLoadRelatedToSaga,
  getLoadTypeSaga,
  getLocationSaga
} from "./select/selectSaga";
import {
  addloadTypesNaturesSaga,
  addMultiloadTypesNaturesSaga,
  deleteloadTypesNaturesSaga, getloadTypesNaturesSaga,
  updateloadTypesNaturesSaga
} from "./crud/load/natures";
import {
  getBusinessByIdSaga,
  getBusinessFeesSaga,
  getFolderTechByIdSaga,
  getFolderTechFeesSaga,
  saveBusinessFeesSaga,
  saveFolderTechFeesSaga,
  updateBusinessFeesSaga,
  updateFolderTechFeesSaga
} from "./crud/fees/feesSaga";
import {
  addEmployeeSaga,
  deleteEmployeeSaga,
  downloadEmployeeDocumentSaga,
  getEmployeeSaga,
  updateEmployeeSaga
} from "./crud/employee/employeeSaga";
import { getSearchResultsSaga, getSearchResultDetailsSaga } from './searchSaga';
import { getBillSaga, getClientToSelectIdSaga, getClientToSelectInBillSaga } from "./Annex/BillSaga";
import {
  addFolderTechSaga,
  deleteFolderTechSaga,
  getFolderTechSaga,
  updateFolderTechSaga
} from "./crud/folderTech/folderTech";
import { downloadFileSaga } from "./syncfusion/fileManagerSaga";
import { getLogList } from './crud/logs/logSaga';
import { getStatisticsInfo } from './statistics';
import {countDownRecievedSaga, getNotificationsListSaga, logsRecievedSaga} from './notificationsSaga';
import {
  addInvoiceSaga,
  deleteInvoiceSaga,
  getInvoiceSaga,
  getInvoiceToSelectSaga,
  updateInvoiceSaga
} from "./crud/charge/invoiceStatus";
import {
  addChargeSaga,
  deleteChargeSaga,
  getChargeSaga,
  getChargeToSelectSaga,
  updateChargeSaga
} from "./crud/charge/loadSaga";
import {
  addChargeTypesNaturesSaga, deleteChargeTypesNaturesSaga,
  getChargeTypesNaturesSaga, getChargeTypesNaturesToSelectSaga,
  updateChargeTypesNaturesSaga
} from "./crud/charge/natures";
export default function* watchUserAuthentication() {
  yield takeLatest(types.REGISTER_USER, registerSaga);
  yield takeLatest(types.CHECK_FOR_TOKING, checkIfAuthenticatedSaga);
  yield takeLatest(types.GET_ROUTE_TO_PROTECT, getRouteToProtectSaga);
  yield takeLatest(types.GET_USER_WITH_PERMISSION, getUsersWithPermissionsSaga);

  yield takeLatest(types.SET_USER_WITH_PERMISSION, setUsersWithPermissionsSaga);
  yield takeLatest(types.GET_BUSINESS_NATURES, getBusinessNaturesSaga);
  yield takeLatest(types.ADD_BUSINESS_NATURES, addBusinessNaturesSaga);
  yield takeLatest(types.UPDATE_BUSINESS_NATURES, updateBusinessNaturesSaga);
  yield takeLatest(types.DELETE_BUSINESS_NATURES, deleteBusinessNaturesSaga);
  yield takeLatest(types.ADD_MULTIPLE_BUSINESS_NATURES, addMultiBusinessNaturesSaga);
  yield takeLatest(types.GET_BUSINESS_SITUATIONS, getBusinessSituationsSaga);
  yield takeLatest(types.ADD_BUSINESS_SITUATIONS, addBusinessSituationsSaga);
  yield takeLatest(types.UPDATE_BUSINESS_SITUATIONS, updateBusinessSituationsSaga);
  yield takeLatest(types.DELETE_BUSINESS_SITUATIONS, deleteBusinessSituationsSaga);
  yield takeLatest(types.ADD_MULTIPLE_BUSINESS_SITUATIONS, addMultiBusinessSituationsSaga);
  yield takeLatest(types.GET_SEARCH_RESULTS, getSearchResultsSaga);
  yield takeLatest(types.GET_SEARCH_RESULTS_DETAILS, getSearchResultDetailsSaga);
  yield takeLatest(types.PRINT_BILL, getBillSaga);
  yield takeLatest(types.CLIENT_BILL_SELECT, getClientToSelectInBillSaga);
  yield takeLatest(types.GET_LOG, getLogList);
  yield takeLatest(types.GET_STATISTICS, getStatisticsInfo);
  yield takeLatest(types.GET_FOLDERTECH_NATURES, getFolderTechNaturesSaga);
  yield takeLatest(types.ADD_FOLDERTECH_NATURES, addFolderTechNaturesSaga);
  yield takeLatest(types.UPDATE_FOLDERTECH_NATURES, updateFolderTechNaturesSaga);
  yield takeLatest(types.DELETE_FOLDERTECH_NATURES, deleteFolderTechNaturesSaga);
  yield takeLatest(types.ADD_MULTIPLE_FOLDERTECH_NATURES, addMultiFolderTechNaturesSaga);
  yield takeLatest(types.GET_CLIENT_FOR_SELECT, addClientsForSelectSaga);
  yield takeLatest(types.GET_CLIENTS, getClientSaga);
  yield takeLatest(types.ADD_CLIENT, addClientSaga);
  yield takeLatest(types.UPDATE_CLIENT, updateClientSaga);
  yield takeLatest(types.DELETE_CLIENT, deleteClientSaga);
  yield takeLatest(types.ADD_MULTIPLE_CLIENT, addMultiClientSaga);
  yield takeLatest(types.GET_INTERMEDIATES, getIntermediatesSaga);
  yield takeLatest(types.ADD_INTERMEDIATE, addIntermediatesSaga);
  yield takeLatest(types.UPDATE_INTERMEDIATE, updateIntermediatesSaga);
  yield takeLatest(types.DELETE_INTERMEDIATE, deleteIntermediatesSaga);
  yield takeLatest(types.ADD_MULTIPLE_INTERMEDIATE, addMultiIntermediatesSaga);
  yield takeLatest(types.GET_FOLDERTECH_SITUATIONS, getFolderTechSituationsSaga);
  yield takeLatest(types.ADD_FOLDERTECH_SITUATIONS, addFolderTechSituationsSaga);
  yield takeLatest(types.UPDATE_FOLDERTECH_SITUATIONS, updateFolderTechSituationsSaga);
  yield takeLatest(types.DELETE_FOLDERTECH_SITUATIONS, deleteFolderTechSituationsSaga);
  yield takeLatest(types.ADD_MULTIPLE_FOLDERTECH_SITUATIONS, addMultiFolderTechSituationsSaga);
  yield takeLatest(types.GET_BUSINESS, getBusinessSaga);
  yield takeLatest(types.ADD_BUSINESS, addBusinessSaga);
  yield takeLatest(types.UPDATE_BUSINESS, updateBusinessSaga);
  yield takeLatest(types.DELETE_BUSINESS, deleteBusinessSaga);
  yield takeLatest(types.GET_FOLDERTECH, getFolderTechSaga);
  yield takeLatest(types.ADD_FOLDERTECH, addFolderTechSaga);
  yield takeLatest(types.UPDATE_FOLDERTECH, updateFolderTechSaga);
  yield takeLatest(types.DELETE_FOLDERTECH, deleteFolderTechSaga);
  yield takeLatest(types.ADD_MULTIPLE_BUSINESS, addMultiBusinessSaga);
  yield takeLatest(types.GET_AUTOCOMPLETE, getAutoCompleteSaga);
  yield takeLatest(types.LOAD_CONVERSATIONS, loadConversationsSaga);
  yield takeLatest(types.LOAD_MESSAGES, loadMessagesSaga);
  yield takeLatest(types.SEND_MESSAGE, sendMessageSaga);
  yield takeLatest(types.LOAD_PREVIOUS_MESSAGES, loadPreviousMessagesSaga);
  yield takeLatest(types.MARK_AS_READ, markAsReadSaga);
  yield takeLatest(types.SET_USER, setUserSaga);
  yield takeLatest(types.DOWNLOAD_FILE_FROM, downloadFileFromSaga);
  yield takeLatest(types.DOWNLOAD_FILE_TO_FILE_MANAGER, downloadFileSaga);
  yield takeLatest(types.MESSAGE_RECIEVED, messageRecievedSaga);
  yield takeLatest(types.GET_LOCATIONS, getLocationsSaga);
  yield takeLatest(types.GET_MISSIONS, getMissionsSaga);
  yield takeLatest(types.ADD_MISSIONS, addMissionsSaga);
  yield takeLatest(types.UPDATE_MISSIONS, updateMissionsSaga);
  yield takeLatest(types.DELETE_MISSIONS, deleteMissionsSaga);
  yield takeLatest(types.GET_GREAT_CADASTRAL_CONSULTATION, getCadastraleConsultationSaga);
  yield takeLatest(types.ADD_MULTIPLE_CADASTRAL_CONSULTATION, addMultiCadastraleConsultationSaga);
  yield takeLatest(types.GET_GREAT_CONSULTATION_SITE, getgreatConstructionSitesSaga);
  yield takeLatest(types.ADD_GREAT_CONSULTATION_SITE, addgreatConstructionSitesSaga);
  yield takeLatest(types.UPDATE_GREAT_CONSULTATION_SITE, updategreatConstructionSitesSaga);
  yield takeLatest(types.GET_STATISTIQUES_GREAT_CONSULTATION_SITE, getSatitstiquesGreatConstructionSiteSaga);
  yield takeLatest(types.DETAILS_GREAT_CONSULTATION_SITE, getDatailsGreatConstructionSiteSaga);
  yield takeLatest(types.DELETE_GREAT_CONSULTATION_SITE, deletegreatConstructionSitesSaga);
  yield takeLatest(types.GET_NOTIFICATIONS, getNotificationsListSaga);
  yield takeLatest(types.GET_LOAD, getLoadsSaga);
  yield takeLatest(types.ADD_LOAD, addLoadsSaga);
  yield takeLatest(types.UPDATE_LOAD, updateLoadsSaga);
  yield takeLatest(types.GET_STATISTIQUES_LOAD, getSatitstiquesLoadSaga);
  yield takeLatest(types.DELETE_LOAD, deleteLoadsSaga);
  yield takeLatest(types.GET_STATISTIQUES_TO_ADMIN, getSatitstiquesSaga);
  yield takeLatest(types.GET_LOAD_TYPES, getLoadTypeSaga);
  yield takeLatest(types.GET_LOAD_RELATED_TO, getLoadRelatedToSaga);
  yield takeLatest(types.GET_LOCATION, getLocationSaga);
  yield takeLatest(types.GET_ALL_LOCATED_BRIGADES, getAllocatedBrigadesSaga);
  yield takeLatest(types.GET_CLIENT_BY_ID, getClientByIdSaga);
  yield takeLatest(types.GET_BUSINESS_NATURE_BY_NAME, getBusinessNaturesByIdSaga);
  yield takeLatest(types.GET_BUSINESS_SITUATION_BY_ID, getBusinessSituationByIdSaga);
  yield takeLatest(types.GET_INTERMEDIATES_BY_ID, getIntermediatesByIdSaga);
  yield takeLatest(types.GET_FOLDER_TECH_NATURE_BY_NAME, getFolderNaturesByNameSaga);
  yield takeLatest(types.GET_FOLDER_TECH_SITUATION_BY_ID, getFolderSituationByIdSaga);
  yield takeLatest(types.DOWNLOAD_EMPLOYEE_DOCUMENTS, downloadEmployeeDocumentSaga);
  yield takeLatest(types.GET_LOAD_NATURES, getloadTypesNaturesSaga);
  yield takeLatest(types.ADD_LOAD_NATURES, addloadTypesNaturesSaga);
  yield takeLatest(types.UPDATE_LOAD_NATURES, updateloadTypesNaturesSaga);
  yield takeLatest(types.DELETE_LOAD_NATURES, deleteloadTypesNaturesSaga);
  yield takeLatest(types.ADD_MULTIPLE_LOAD_NATURES, addMultiloadTypesNaturesSaga);
  yield takeLatest(types.GET_FOLDER_TECH_BY_ID, getFolderTechByIdSaga);
  yield takeLatest(types.GET_BUSINESS_BY_ID, getBusinessByIdSaga);
  yield takeLatest(types.GET_BUSINESS_FEES, getBusinessFeesSaga);
  yield takeLatest(types.GET_FOLDER_TECH_FEES, getFolderTechFeesSaga);
  yield takeLatest(types.ADD_BUSINESS_FEES, saveBusinessFeesSaga);
  yield takeLatest(types.ADD_FOLDER_TECH_FEES, saveFolderTechFeesSaga);
  yield takeLatest(types.UPDATE_BUSINESS_FEES, updateBusinessFeesSaga);
  yield takeLatest(types.UPDATE_FOLDER_TECH_FEES, updateFolderTechFeesSaga);
  yield takeLatest(types.LOGIN_USER, loginSaga);
  yield takeLatest(types.GET_PROFILE, getImageProfile);
  yield takeLatest(types.SET_PROFILE, setImageProfileSaga);
  yield takeLatest(types.SET_PROFILE_STORAGE, setImageProfileFromStorageSaga);
  yield takeLatest(types.GET_INVOICE_STATUS, getInvoiceSaga);
  yield takeLatest(types.ADD_INVOICE_STATUS, addInvoiceSaga);
  yield takeLatest(types.UPDATE_INVOICE_STATUS, updateInvoiceSaga);
  yield takeLatest(types.DELETE_INVOICE_STATUS, deleteInvoiceSaga);
  yield takeLatest(types.GET_INVOICE_STATUS_TO_SELECT, getInvoiceToSelectSaga);
  yield takeLatest(types.GET_CHARGES, getChargeSaga);
  yield takeLatest(types.ADD_CHARGES, addChargeSaga);
  yield takeLatest(types.UPDATE_CHARGES, updateChargeSaga);
  yield takeLatest(types.DELETE_CHARGES, deleteChargeSaga);
  yield takeLatest(types.GET_EMPLOYEES, getEmployeeSaga);
  yield takeLatest(types.ADD_EMPLOYEE, addEmployeeSaga);
  yield takeLatest(types.UPDATE_EMPLOYEE, updateEmployeeSaga);
  yield takeLatest(types.DELETE_EMPLOYEE, deleteEmployeeSaga);
  yield takeLatest(types.GET_CHARGES_NATURES, getChargeTypesNaturesSaga);
  yield takeLatest(types.GET_CHARGES_NATURES_TO_SELECT, getChargeTypesNaturesToSelectSaga);
  yield takeLatest(types.ADD_CHARGES_NATURES, addChargeTypesNaturesSaga);
  yield takeLatest(types.UPDATE_CHARGES_NATURES, updateChargeTypesNaturesSaga);
  yield takeLatest(types.DELETE_CHARGES_NATURES, deleteChargeTypesNaturesSaga);

  yield takeLatest(types.LOGS_RECIEVED, logsRecievedSaga);
  yield takeLatest(types.COUNT_DOWN_RECIEVED, countDownRecievedSaga);
}
