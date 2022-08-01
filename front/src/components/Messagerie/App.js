import React from 'react';
import PropTypes from 'prop-types';
import { withStyles } from 'material-ui/styles';
import { Router, Route, Switch, Redirect } from 'react-router-dom';
// import PrivateRoute from '../containers/PrivateRoute';
// import WelcomePage from '../containers/WelcomePage';
// import ChatPage from '../../../../containers/ChatPage';
import history from '../../utils/history';
import ChatPage from "../../container/ChatPage";
import PrivateRoute from "../../container/privateRoute";

const styles = theme => ({
  root: {
    position: 'relative',
    display: 'flex',
    width: '100%',
    height: '100%',
    backgroundColor: theme.palette.background.default,
  },
});

const App = ({ classes }) => (
  <Router history={history}>
    <div className={classes.root}>
      <Switch>
        <PrivateRoute path="/chat/:chatId?" component={ChatPage} />
        <Redirect to="/" />
      </Switch>
    </div>
  </Router>
);

App.propTypes = {
  classes: PropTypes.objectOf(PropTypes.string).isRequired,
};

export default withStyles(styles)(App);
