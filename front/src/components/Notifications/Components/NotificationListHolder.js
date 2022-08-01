import React, {Component} from 'react';
import {withStyles} from '@material-ui/core';
import NotificationHeaderContainer from './NotificationHeader';
import NotificationCardContainer from './NotificationCard';
import Scrollbar from 'react-scrollbars-custom';


const style = {
    root: {
        display: 'flex',
        flexDirection: 'column',
    },
    card: {
        flexBasis: 40,
    },
    trackY: {
        width: "7 !important",
        marginRight: 3,
    }
}
const NotificationListHolder = ({classes, content, onEndScrollReached}) => {

    const handleOnScroll = (scrollValues) => {
        const {clientHeight, contentScrollHeight, scrollTop} = scrollValues;

        if (clientHeight + scrollTop === contentScrollHeight) {
            onEndScrollReached && onEndScrollReached();
        }
    }
    return (
        <Scrollbar
            style={{width: "100%", height: "100%"}}
            removeTracksWhenNotUsed={true}
            trackYProps={{
                renderer: props => {
                    const {elementRef, ...restProps} = props;
                    return <span {...restProps} style={{...restProps.style, width: 7}} ref={elementRef}
                                 className={classes.trackY}/>;
                }
            }}
            onScrollStop={handleOnScroll}
        >

            {
                Array.isArray(content)
                && content.map((notification, index) => (
                    <NotificationCardContainer
                        type="info"
                        title={'Notifications Title ' + notification.id}
                        description={notification.description}
                        date={notification.created_at}
                    />
                ))
            }
        </Scrollbar>
    );
}

const NotificationListHolderContainer = withStyles(style, {name: "NotificationListHolder"})(NotificationListHolder);
export default NotificationListHolderContainer;
