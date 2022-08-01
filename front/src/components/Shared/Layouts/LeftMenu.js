import React, { Component } from "react";
import { Switch, Route, Link } from "react-router-dom";
import { Links } from "../../../Constansts/LeftMenu";
import ListItem from "@material-ui/core/ListItem";
import ListItemText from "@material-ui/core/ListItemText";
import { ExpandLess, ExpandMore, AccountCircle } from "@material-ui/icons";
import Collapse from "@material-ui/core/Collapse";
import Drawer from "@material-ui/core/Drawer";
import List from "@material-ui/core/List";
import withStyles from "@material-ui/core/styles/withStyles";
import CssBaseline from "@material-ui/core/CssBaseline";
import AppBar from "@material-ui/core/AppBar";
import clsx from "clsx";
import Toolbar from "@material-ui/core/Toolbar";
import IconButton from "@material-ui/core/IconButton";
import Typography from "@material-ui/core/Typography";
import MenuIcon from "@material-ui/icons/Menu";
import ChevronLeftIcon from "@material-ui/icons/ChevronLeft";
import ChevronRightIcon from "@material-ui/icons/ChevronRight";
import Container from "@material-ui/core/Container";
import classNames from "classnames";
import MailIcon from "@material-ui/icons/Mail";
import NotificationsIcon from "@material-ui/icons/Notifications";
import SearchIcon from "@material-ui/icons/Search";
import MoreIcon from "@material-ui/icons/MoreVert";

import { fade, makeStyles } from "@material-ui/core/styles";
import { Menu, MenuItem, Badge, InputBase, Avatar } from "@material-ui/core";

const drawerWidth = 280;
export const menuId = "primary-search-account-menu";
export const mobileMenuId = "primary-search-account-menu-mobile";

const styles = (theme) => ({
  root: {
    display: "flex",
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
});

class LeftMenu extends Component {
  constructor(props) {
    super(props);
    this.state = {
      component: null,
      open: false,
      anchorProfile: null,
      anchorNotifs: null,
      anchorMessages: null,
      isMobileMenuOpen: false,
    };
  }

  handleClick(item) {
    this.setState((prevState) => ({ [item]: !prevState[item] }));
  }

  handler(children, paddingLeft = 0) {
    const { classes } = this.props;
    const { state } = this;
    return children.map((subOption) => {
      if (!subOption.children) {
        return (
          <div key={subOption.name}>
            <ListItem
              button
              key={subOption.name}
              style={{ paddingLeft: paddingLeft * 20 }}
              className={classNames(
                window.location.pathname === subOption.url
                  ? classes.OptionSelected
                  : {}
              )}
            >
              <Link to={subOption.url} className={classes.links}>
                <ListItemText
                  inset
                  primary={subOption.name}
                  className={classes.Option}
                />
              </Link>
            </ListItem>
          </div>
        );
      }
      return (
        <div key={subOption.name}>
          <ListItem
            button
            style={{ paddingLeft: 0 }}
            onClick={() => this.handleClick(subOption.name)}
            className={state[subOption.name] ? classes.OptionParent : {}}
          >
            <ListItemText
              inset
              primary={subOption.name}
              className={classes.Option}
            />
            {state[subOption.name] ? <ExpandLess /> : <ExpandMore />}
          </ListItem>
          <Collapse
            in={state[subOption.name]}
            className={classes.OptionChild}
            timeout="auto"
            unmountOnExit
          >
            {this.handler(subOption.children, paddingLeft + 1)}
          </Collapse>
        </div>
      );
    });
  }

  render() {
    const { classes } = this.props;
    const { open, onClose } = this.props;
    const { anchorProfile, anchorNotifs, anchorMessages } = this.state;
    return (
      <div className={classes.list}>
        <Drawer
          className={classes.drawer}
          variant="persistent"
          anchor="left"
          open={open}
          classes={{
            paper: classes.drawerPaper,
          }}
        >
          <div className={classes.drawerHeader}>
            <IconButton onClick={onClose}>
              {open ? <ChevronLeftIcon /> : <ChevronRightIcon />}
            </IconButton>
          </div>
          <div>
            <List>{this.handler(Links)}</List>
          </div>
        </Drawer>
      </div>
    );
  }
}
export default withStyles(styles)(LeftMenu);
