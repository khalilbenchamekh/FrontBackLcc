import React, {Component} from 'react';
import {withStyles} from '@material-ui/core';
import NotificationHeaderContainer from '../Components/NotificationHeader';
import NotificationFooterContainer from '../Components/NotificationFooter';
import NotificationListHolderContainer from '../Components/NotificationListHolder';
import {compose} from 'redux';
import {getNotificationsLimit} from "../../../actions/notificationActions";
import {connect} from 'react-redux';
import {getCookie} from "../../../utils/cookies";


const style = {
    root: {
        width: "450px",
        height: "600px",
        backgroundColor: "#FFFFFF",
        display: 'flex',
        flexDirection: 'column',
        color: "#333333"
    },
    header: {
        flexBasis: 40,
    },
    list: {
        flexGrow: 1,
    },
    footer: {
        flexBasis: 30,
    }
}

class NotificationPopUp extends Component {

    constructor(props) {
        super(props);
        this.state = {
            position: 1,
            redirect: false,

            length: 15
        }
    }

    componentDidMount() {
        const {getNotificationsLimit} = this.props;
        const {position, length} = this.state;
        let token = this.props.token === "" ? getCookie("token") : this.props.token;
        if (token) {
            getNotificationsLimit(token, position, length);
        }
    }

    handleOnViewMoreClick = () => {
        const {onHideRequest} = this.props;
        onHideRequest();
    }

    render() {
        const {classes, unread, content} = this.props;
        return (
            <div className={classes.root}>
                <div className={classes.header}>
                    <NotificationHeaderContainer
                        count={unread > 9 ? "+9" : unread}
                    />
                </div>
                <div className={classes.list}>
                    <NotificationListHolderContainer
                        content={content}
                    />
                </div>
                <div className={classes.footer}>
                    <NotificationFooterContainer
                        onViewMoreClick={this.handleOnViewMoreClick}
                    />
                </div>
            </div>
        );
    }
}

function mapStateToProps(state) {
    return {
        token: state.login.token,
        unread: state.notifications.unread,
        content: state.notifications.content
    };
}

const mapDispatchToProps = {
    getNotificationsLimit,

};
const NotificationPopUpContainer = compose(connect(mapStateToProps, mapDispatchToProps), withStyles(style, {name: "NotificationPopUp"}))(NotificationPopUp);
export default NotificationPopUpContainer;
