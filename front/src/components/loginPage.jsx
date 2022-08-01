import React, {Component} from "react";
import {Redirect} from "react-router-dom";
import {connect} from "react-redux";

import {loginUserAction} from "../actions/authenticationActions";
import {setCookie} from "../utils/cookies";

import Avatar from "@material-ui/core/Avatar";
import Button from "@material-ui/core/Button";
import CssBaseline from "@material-ui/core/CssBaseline";
import TextField from "@material-ui/core/TextField";
import FormControlLabel from "@material-ui/core/FormControlLabel";
import Checkbox from "@material-ui/core/Checkbox";
import Link from "@material-ui/core/Link";

import Grid from "@material-ui/core/Grid";
import Box from "@material-ui/core/Box";
import LockOutlinedIcon from "@material-ui/icons/LockOutlined";
import Typography from "@material-ui/core/Typography";
import {withStyles} from "@material-ui/core/styles";
import Container from "@material-ui/core/Container";
import {daysToken, owner} from "../Constansts/file";

function Copyright() {
    return (
        <Typography variant="body2" color="textSecondary" align="center">
            {"Copyright © "}
            <Link color="inherit" href="https://material-ui.com/">
                Your Website
            </Link>{" "}
            {new Date().getFullYear()}
            {"."}
        </Typography>
    );
}

const styles = (theme) => ({
    "@global": {
        body: {
            backgroundColor: "#ffffff !important",
        },
    },
    paper: {
        background: "linear-gradient(45deg, #4099ff44, #73b4ff33);",
        width: "40vw",
        margin: "auto",
        marginTop: theme.spacing(8),
        display: "flex",
        flexDirection: "column",
        alignItems: "center",
        padding: "2vh 1vw 4vh 1vw",
        border: "solid thin #00000022",
        boxShadow: "2px 4px 5px #00000066",
        borderRadius: 10,
        "&:hover": {
            boxShadow: "1px 3px 3px #00000066",
            border: "solid thin #00000033",
        },
    },
    avatar: {
        margin: theme.spacing(1),
        backgroundColor: theme.palette.secondary.main,
    },
    checkBox: {
        color: "#000000 !important",
    },
    form: {
        // Fix IE 11 issue.
        marginTop: theme.spacing(1),
        "& label": {
            color: "#000000 !important",
            fontWeight: "400 !important",
            fontSize: "1.2em !important",
        },
        "& input": {
            backgroundColor: "#ffffff important",
        },
    },
    submit: {
        marginBottom: 23,
        width: "auto",
        float: "right",
    },
});

class LoginPage extends Component {
    constructor(props) {
        super(props);
        this.state = {
            isSuccess: undefined,
            routeToRedirect: undefined,
            token: undefined,
            role: undefined,
        };
    }

    onHandleLogin = (event) => {
        event.preventDefault();

        let email = event.target.email.value;
        let password = event.target.password.value;

        const data = {
            email,
            password,
        };

        this.props.dispatch(loginUserAction(data));
    };

    componentDidMount() {
        document.title = "React Login";
    }

    componentWillReceiveProps(nextProps, nextContext) {
        let isSuccess, routeToRedirect, token, role;

        if (nextProps.response.login.hasOwnProperty("response")) {
            let response = nextProps.response.login.response;
            if (response) {
                if (nextProps.response.login.response.hasOwnProperty("token")) {
                    routeToRedirect = "home";
                    if (response.data) {
                        let data = response.data;
                        if (data.customClaims) {
                            let customClaims = data.customClaims;
                            if (customClaims) {
                                let Role = customClaims.Role;
                                role = Role;
                            }
                        }
                    }
                    if (role === owner) {
                        routeToRedirect = routeToRedirect;
                    }
                    isSuccess = true;
                    token = response.token;
                    setCookie("token", token, daysToken);
                    this.setState({
                        isSuccess: isSuccess,
                        routeToRedirect: routeToRedirect,
                        token: token,
                        role: role,
                    });
                }
            }
        }
    }

    render() {
        const {classes} = this.props;
        const {isSuccess, routeToRedirect} = this.state;

        return (
            <Container component="main" maxWidth="xs">
                {!isSuccess ? (
                    <div>{routeToRedirect}</div>
                ) : (
                    <Redirect to={routeToRedirect}/>
                )}
                <CssBaseline/>
                <div className={classes.paper}>
                    <Avatar className={classes.avatar}>
                        <LockOutlinedIcon/>
                    </Avatar>
                    <Typography className="mb-4" component="h1" variant="h5">
                        Authentification
                    </Typography>
                    <form className={classes.form} onSubmit={this.onHandleLogin}>
                        <TextField
                            variant="outlined"
                            margin="normal"
                            required
                            fullWidth
                            id="email"
                            label="Email Address"
                            name="email"
                            autoComplete="email"
                            autoFocus
                        />
                        <TextField
                            variant="outlined"
                            margin="normal"
                            required
                            fullWidth
                            name="password"
                            label="Password"
                            type="password"
                            id="password"
                            autoComplete="current-password"
                        />
                        <FormControlLabel
                            color="primary"
                            control={
                                <Checkbox
                                    color="primary"
                                    inputProps={{"aria-label": "secondary checkbox"}}
                                    value="remember"
                                />
                            }
                            label="rester connecté"
                        />
                        <div>
                            <Button
                                type="submit"
                                fullWidth
                                variant="contained"
                                color="primary"
                                className={classes.submit}
                            >
                                Se connecter
                            </Button>
                        </div>
                        <Grid container>
                            <Grid item xs>
                                <Link href="#" variant="body2">
                                    Mot de passe oublié?
                                </Link>
                            </Grid>
                            <Grid item>
                                <Link href="#" variant="body2">
                                    {"Vous n'avez pas de compte? S'inscrire"}
                                </Link>
                            </Grid>
                        </Grid>
                    </form>
                </div>
                <Box mt={8}>
                    <Copyright/>
                </Box>
            </Container>
        );
    }
}

const mapStateToProps = (response) => ({response});

export default withStyles(styles)(connect(mapStateToProps)(LoginPage));
