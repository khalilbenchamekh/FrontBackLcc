import React, {Component} from "react";
import {Switch, Route, Link, NavLink} from "react-router-dom";
import ListItem from "@material-ui/core/ListItem";
import ListItemText from "@material-ui/core/ListItemText";
import {ExpandLess, ExpandMore, AccountCircle} from "@material-ui/icons";
import Collapse from "@material-ui/core/Collapse";
import withStyles from "@material-ui/core/styles/withStyles";
import CssBaseline from "@material-ui/core/CssBaseline";
import AppBar from "@material-ui/core/AppBar";
import clsx from "clsx";
import Toolbar from "@material-ui/core/Toolbar";
import IconButton from "@material-ui/core/IconButton";
import Typography from "@material-ui/core/Typography";
import FolderIcon from '@material-ui/icons/Folder';
import MenuIcon from "@material-ui/icons/Menu";
import HomeIcon from '@material-ui/icons/Home';
import classNames from "classnames";
import MailIcon from "@material-ui/icons/Mail";
import NotificationsIcon from "@material-ui/icons/Notifications";
import ListAltIcon from '@material-ui/icons/ListAlt';
import MoreIcon from "@material-ui/icons/MoreVert";
import {fade, makeStyles} from "@material-ui/core/styles";
import {Menu, MenuItem, Badge, InputBase, Avatar} from "@material-ui/core";
import NotificationPopUp from "../Notifications/Views/NotificationPopUp";
import {getCookie, getProfileFromCookie} from "../../utils/cookies";
import {addBusinessAction} from "../../actions/businessActions";
import {compose} from "recompose";
import {connect} from "react-redux";
import StandardAvatar from '../../assets/profile_backup.png';
import {setProfileFromStorageAction} from "../../actions/profileActions";


const drawerWidth = 280;
const menuId = "primary-search-account-menu";
const mobileMenuId = "primary-search-account-menu-mobile";

const styles = (theme) => ({
    root: {
        display: "flex",
    },
    appBar: {
        transition: theme.transitions.create(["margin", "width"], {
            easing: theme.transitions.easing.sharp,
            duration: theme.transitions.duration.leavingScreen,
        }),
        backgroundColor: "#343a40",
    },
    appBarShift: {
        width: `calc(100% - ${drawerWidth}px)`,
        marginLeft: drawerWidth,
        transition: theme.transitions.create(["margin", "width"], {
            easing: theme.transitions.easing.easeOut,
            duration: theme.transitions.duration.enteringScreen,
        }),
    },
    menuButton: {
        marginRight: theme.spacing(2),

        "&:hover": {
            backgroundColor: "#ffffff33",
        },
    },
    hide: {
        display: "none",
    },
    drawer: {
        width: drawerWidth,
        flexShrink: 0,
    },
    drawerPaper: {
        width: drawerWidth,
        backgroundColor: "#343a40",
        color: "#ffffff",
    },
    drawerHeader: {
        display: "flex",
        alignItems: "center",
        padding: theme.spacing(0, 1),
        ...theme.mixins.toolbar,
        justifyContent: "flex-end",
        backgroundColor: "#212928",
    },
    content: {
        flexGrow: 1,
        padding: theme.spacing(3),
        transition: theme.transitions.create("margin", {
            easing: theme.transitions.easing.sharp,
            duration: theme.transitions.duration.leavingScreen,
        }),
        marginLeft: -drawerWidth,
    },
    contentShift: {
        transition: theme.transitions.create("margin", {
            easing: theme.transitions.easing.easeOut,
            duration: theme.transitions.duration.enteringScreen,
        }),
    },
    list: {
        width: 250,
    },
    links: {
        textDecoration: "none",
        padding: 0,
        color: "#ffffff",
        "&:hover": {
            color: "#ffffff",
            textDecoration: "none",
        },
    },
    menuHeader: {
        paddingLeft: "30px",
    },
    Option: {
        paddingLeft: "20px",
    },
    OptionParent: {
        backgroundColor: "#00000049",
    },
    OptionChild: {
        backgroundColor: "#00000033",
        boxShadow: "0px 1px 5px #f8f9fa15",
    },
    OptionSelected: {
        background: "linear-gradient(45deg, #4099ff, #73b4ff);",
        "&:hover": {
            backgroundColor: "#fd7e14",
        },
    },

    grow: {
        flexGrow: 1,
    },
    title: {},
    search: {
        position: "relative",
        borderRadius: theme.shape.borderRadius,
        backgroundColor: fade(theme.palette.common.white, 0.15),
        "&:hover": {
            backgroundColor: fade(theme.palette.common.white, 0.25),
        },
        marginRight: theme.spacing(2),
        marginLeft: 0,
        width: "100%",
        [theme.breakpoints.up("sm")]: {
            marginLeft: theme.spacing(3),
            width: "auto",
        },
    },
    inputRoot: {
        color: "inherit",
    },
    inputInput: {
        padding: theme.spacing(1, 1, 1, 0),
        // vertical padding + font size from searchIcon
        paddingLeft: `calc(1em + ${theme.spacing(4)}px)`,
        transition: theme.transitions.create("width"),
        width: "100%",
        [theme.breakpoints.up("md")]: {
            width: "20ch",
        },
    },
    sectionDesktop: {
        display: "none",
        [theme.breakpoints.up("md")]: {
            display: "flex",
        },
    },
    sectionMobile: {
        display: "flex",
        [theme.breakpoints.up("md")]: {
            display: "none",
        },
    },
    homeIcon: {
        color: "white",
    },
    notifications: {
        padding: 0,
        "& ul": {
            padding: 0,
        }
    }
});

class MenuBar extends Component {
    constructor(props) {
        super(props);
        this.state = {
            component: null,
            avatar: undefined,
            dataUser: undefined,
            open: false,
            anchorProfile: null,
            anchorNotifs: null,
            anchorMessages: null,
            isMobileMenuOpen: false,
        };
    }

    handleClick(item) {
        this.setState((prevState) => ({[item]: !prevState[item]}));
    }

    handleDrawerOpen = (e) => {
        this.setState({open: !this.state.open});
    };

    componentWillReceiveProps(nextProps) {
        this.setState({componet: nextProps.componet});


        if (this.props.token !== nextProps.token) {
            let dataUser = getProfileFromCookie();
            let avatar = undefined;
            if (dataUser && dataUser.avatar) {
                avatar = dataUser.avatar;
            } else {
                avatar = StandardAvatar;
            }
            this.props.setProfileFromStorageAction(dataUser);
            this.setState({
                dataUser: dataUser,
                avatar: avatar,
            });
        }
    }


    handleMessageMenuOpen = (event) => {
        this.setState({anchorMessages: event.currentTarget});
    };

    handleNotifsMenuOpen = (event) => {
        this.setState({anchorNotifs: event.currentTarget});
    };


    handleMenuNotifsClose = () => {
        this.setState({anchorNotifs: null});
    };

    handleMenuMessagesClose = () => {
        this.setState({anchorMessages: null});
    };

    handleMobileMenuOpen = (event) => {
        this.setState({mobileMoreAnchorEl: event.currentTarget});
    };

    render() {
        const {classes, onMenuOpen, content, unread} = this.props;
        const {open, avatar} = this.state;
        const {anchorProfile, anchorNotifs, anchorMessages} = this.state;
        const isMenuOpenNotifs = Boolean(anchorNotifs);
        const isMenuOpenMessage = Boolean(anchorMessages);
        return (
            <>
                <AppBar
                    position="fixed"
                    className={clsx(classes.appBar, {
                        [classes.appBarShift]: open,
                    })}
                >
                    <Toolbar>
                        <IconButton
                            color="inherit"
                            aria-label="open drawer"
                            onClick={onMenuOpen}
                            edge="start"
                            className={clsx(classes.menuButton, open && classes.hide)}
                        >
                            <MenuIcon className={classes.homeIcon}/>
                        </IconButton>
                        <NavLink to="/home">
                            <IconButton
                                color="inherit"
                                aria-label="open drawer"
                                edge="start"
                                className={clsx(classes.menuButton, open && classes.hide)}
                            >

                                <HomeIcon className={classes.homeIcon}/>
                            </IconButton>
                        </NavLink>
                        <Typography variant="h6" noWrap>
                            Vue Globale
                        </Typography>
                        <div className={classes.grow}/>
                        <div className={classes.sectionDesktop}>
                            {/* Planing */}
                            <IconButton
                                aria-label="show 4 new mails"
                                color="inherit"
                            >
                                <Badge badgeContent={0} color="secondary">
                                    <NavLink to="/planing"><ListAltIcon className="text-white mb-2"/>
                                    </NavLink>
                                </Badge>
                            </IconButton>
                            {/* FileManager */}
                            <IconButton
                                aria-label="show 4 new mails"
                                color="inherit"
                            >
                                <Badge badgeContent={0} color="secondary">
                                    <NavLink to="/fileManager">
                                        <FolderIcon className="text-white mb-2"/>
                                    </NavLink>
                                </Badge>
                            </IconButton>
                            {/* Messages */}
                            <IconButton
                                aria-label="show  new mails"
                                color="inherit"
                                onClick={this.handleMessageMenuOpen}
                            >
                                <Badge badgeContent={unread} color="secondary">

                                    <NavLink to="/messaging"><MailIcon className="text-white mb-2"/>
                                    </NavLink>
                                </Badge>
                            </IconButton>
                            {/* Notifications */}
                            <IconButton
                                aria-label="show new notifications"
                                color="inherit"
                                onClick={this.handleNotifsMenuOpen}
                            >
                                <Badge badgeContent={content > 9 ? "+9" : content} color="secondary">
                                    <NotificationsIcon className="text-white mb-2"/>
                                </Badge>
                            </IconButton>
                            {/* Profile */}
                            <NavLink to="/profile">
                                <IconButton
                                    edge="end"
                                    aria-label="account of current user"
                                    aria-controls={menuId}
                                    aria-haspopup="true"
                                    color="inherit"
                                >
                                    <div className={classes.sectionMobile}>
                                        <IconButton
                                            aria-label="show more"
                                            aria-controls={mobileMenuId}
                                            aria-haspopup="true"
                                            onClick={this.handleMobileMenuOpen}
                                            color="inherit"
                                        >
                                            <MoreIcon/>
                                        </IconButton>
                                    </div>
                                    <Avatar
                                        alt="Remy Sharp"
                                        src=
                                            {
                                                avatar === null ? "https://material-ui.com/static/images/avatar/2.jpg" : avatar
                                            }

                                    />


                                </IconButton>
                            </NavLink>
                        </div>
                    </Toolbar>
                </AppBar>
                {/* Notification */}
                <Menu
                    anchorEl={anchorNotifs}
                    anchorOrigin={{vertical: "top", horizontal: "right"}}
                    id={menuId}
                    keepMounted
                    transformOrigin={{vertical: "top", horizontal: "right"}}
                    open={isMenuOpenNotifs}
                    onClose={this.handleMenuNotifsClose}
                    className={classes.notifications}
                >
                    <NotificationPopUp onHideRequest={this.handleMenuNotifsClose}/>
                </Menu>
                {/* Messages */}
                {/*<Menu*/}
                {/*anchorEl={anchorMessages}*/}
                {/*anchorOrigin={{vertical: "top", horizontal: "right"}}*/}
                {/*id={menuId}*/}
                {/*keepMounted*/}
                {/*transformOrigin={{vertical: "top", horizontal: "right"}}*/}
                {/*open={isMenuOpenMessage}*/}
                {/*onClose={this.handleMenuMessagesClose}*/}
                {/*>*/}
                {/*<NotificationPopUp onHideRequest={this.handleMenuMessagesClose}/>*/}

                {/*</Menu>*/}
            </>
        );
    }
}

const mapDispatchToProps = {
    setProfileFromStorageAction
};

function mapStateToProps(state) {
    return {
        token: state.login.token,
        data: state.login.data,
        content: state.notifications.unread,
        unread: state.conversations.unread,


    };
}

export default compose(
    withStyles(styles, {
        name: "CustomToolbar"
    }),
    connect(mapStateToProps, mapDispatchToProps)
)(MenuBar);
