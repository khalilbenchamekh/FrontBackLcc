import React, {Component} from 'react';
import PropTypes from 'prop-types';
import {withStyles} from '@material-ui/styles';
import {Avatar} from '@material-ui/core';
import ConversationMessage from './ConversationMessage';
import Scrollbar from 'react-scrollbars-custom';
import Separator from "../Shared/Separator";
import moment from "moment";
import {compose} from 'recompose';
import {connect} from "react-redux";

import MessageComponent from "./MessagesComponents";
import {getCookie} from "../../utils/cookies";
import {downloadFileFromAction} from "../../actions/messagerie/messagerieActions";
import {Menagerie} from "../../Constansts/conversation";
import {AttachFile} from "@material-ui/icons";


const styles = {

};
const Conversation = ({classes, messages, user,token}) => {

};

const mapDispatchToProps = {
    downloadFileFromAction
};


export default compose(
    withStyles(styles),
    connect(null, mapDispatchToProps)
)(Conversation);
