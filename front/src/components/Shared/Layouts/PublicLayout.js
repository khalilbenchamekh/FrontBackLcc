import React, { Component } from "react";
import LeftMenu from "../../Shared/Layouts/LeftMenu";
import PublicRouterPage from "../../Routers/PublicRouterPage";
import NavBar from "../../menu/NavBar";
import clsx from "clsx";
import { checkForTokenAction } from "../../../actions/authenticationActions";
import { compose } from "recompose";
import { connect } from "react-redux";
import withStyles from "@material-ui/core/styles/withStyles";
import { fade, makeStyles } from "@material-ui/core/styles";
import { userRole } from "../../../Constansts/file";
import { checkCookie } from "../../../utils/cookies";

const drawerWidth = 280;

const styles = (theme) => ({
  root: {
    display: "flex",
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
  drawerHeader: {
    display: "flex",
    alignItems: "center",
    padding: theme.spacing(0, 1),
    ...theme.mixins.toolbar,
    minHeight: "32px !important",
    justifyContent: "flex-end",
    backgroundColor: "#212928",
  },
});

class AdminLayout extends Component {
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

  componentDidMount() {
    this.props.checkForTokenAction();
    if (checkCookie() !== userRole) {
      window.location.ref = "/";
    }
  }
  handleClick(item) {
    this.setState((prevState) => ({ [item]: !prevState[item] }));
  }

  handleDrawerOpen = (e) => {
    this.setState({ open: !this.state.open });
  };

  componentWillReceiveProps(nextProps) {
    this.setState({ componet: nextProps.componet });
  }
  render() {
    const { classes } = this.props;
    const { open } = this.state;
    return (
      <div className="">
        <div className={classes.root}>
          <NavBar onMenuOpen={this.handleDrawerOpen} />
          <LeftMenu
            open={open}
            onClose={this.handleDrawerOpen}
            handleClick={this.handleClick}
          />
          <main
            className={clsx(classes.content, {
              [classes.contentShift]: !open,
            })}
            style={{}}
          >
            <div className={classes.drawerHeader} />
            <PublicRouterPage />
          </main>
        </div>
      </div>
    );
  }
}

const mapDispatchToProps = {
  checkForTokenAction,
};

function mapStateToProps(state) {
  return {
    token: state,
  };
}



export default compose(
  withStyles(styles, {
    name: "publicLayout",
  }),
  connect(mapStateToProps, mapDispatchToProps)
)(AdminLayout);
