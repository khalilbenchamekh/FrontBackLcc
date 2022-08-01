import {withStyles} from '@material-ui/core';
import React, {Component} from 'react';
import NotificationHeaderContainer from '../Components/NotificationHeader';
import NotificationListHolderContainer from '../Components/NotificationListHolder';
import {compose} from 'redux';
import {getNotificationsLimit} from '../../../actions/notificationActions';
import {connect} from 'react-redux';
import {getCookie} from "../../../utils/cookies";


const style = {
    root: {
        height: "85vh",
        backgroundColor: "#FFFFFF",
        display: 'flex',
        flexDirection: 'column',
        color: "#333333",
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

class NotificationPage extends Component {
    constructor(props) {
        super(props);
        this.state = {
            position: 1,
            length: 15
        }
    }

    // componentDidMount() {
    //     const {getNotificationsLimit} = this.props;
    //     const {position, length} = this.state;
    //     let token = this.props.token === "" ? getCookie("token") : this.props.token;
    //
    //     getNotificationsLimit(token, position, length);
    // }

    loadMore = () => {
        const {getNotificationsLimit} = this.props;
        let token = this.props.token === "" ? getCookie("token") : this.props.token;
        if(token){
            this.setState((prevState) => ({position: prevState.position + prevState.length}), () => getNotificationsLimit(token, this.state.position, this.state.length))
        }
    }

    render() {
        const {classes, unread,content} = this.props;
        return (
            <div className={classes.root}>
                <div className={classes.header}>
                    <NotificationHeaderContainer
                        count={unread}
                    />
                </div>
                <div className={classes.list}>
                    <NotificationListHolderContainer
                        content={content} // put content after service is done
                        onEndScrollReached={this.loadMore}
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
}
const NotificationPageContainer = compose(connect(mapStateToProps, mapDispatchToProps), withStyles(style, {name: "NotificationPage"}))(NotificationPage);
export default NotificationPageContainer;
