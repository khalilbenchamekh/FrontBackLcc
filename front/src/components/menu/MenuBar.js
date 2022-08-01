import React, {Component} from 'react'
import {Switch, Route, Link} from 'react-router-dom'
import menuItems from './menuItems'
import ListItem from "@material-ui/core/ListItem";
import ListItemText from "@material-ui/core/ListItemText";
import {ExpandLess, ExpandMore} from "@material-ui/icons";
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
import MenuIcon from '@material-ui/icons/Menu';
import ChevronLeftIcon from '@material-ui/icons/ChevronLeft';
import ChevronRightIcon from '@material-ui/icons/ChevronRight';
import Container from "@material-ui/core/Container";
import Permissions from "../Admin/permissions";
import businessNature from "../business/natures";
import businessSituation from "../business/situations";
import folderTechNature from "../folderTech/natures/index";
import folderTechSituation from "../folderTech/situations/index";

import client from "../CustomerRelationship/client/index";
import intermediate from "../CustomerRelationship/intermediate/index";
import business from "../business/business/index";
import Dashboard from "../dashboard";

const drawerWidth = 240;

const styles = theme => ({
    root: {
        display: 'flex',
    },
    appBar: {
        transition: theme.transitions.create(['margin', 'width'], {
            easing: theme.transitions.easing.sharp,
            duration: theme.transitions.duration.leavingScreen,
        }),
    },
    appBarShift: {
        width: `calc(100% - ${drawerWidth}px)`,
        marginLeft: drawerWidth,
        transition: theme.transitions.create(['margin', 'width'], {
            easing: theme.transitions.easing.easeOut,
            duration: theme.transitions.duration.enteringScreen,
        }),
    },
    menuButton: {
        marginRight: theme.spacing(2),
    },
    hide: {
        display: 'none',
    },
    drawer: {
        width: drawerWidth,
        flexShrink: 0,
    },
    drawerPaper: {
        width: drawerWidth,
    },
    drawerHeader: {
        display: 'flex',
        alignItems: 'center',
        padding: theme.spacing(0, 1),
        ...theme.mixins.toolbar,
        justifyContent: 'flex-end',
    },
    content: {
        flexGrow: 1,
        padding: theme.spacing(3),
        transition: theme.transitions.create('margin', {
            easing: theme.transitions.easing.sharp,
            duration: theme.transitions.duration.leavingScreen,
        }),
        marginLeft: -drawerWidth,
    },
    contentShift: {
        transition: theme.transitions.create('margin', {
            easing: theme.transitions.easing.easeOut,
            duration: theme.transitions.duration.enteringScreen,
        }),
    },
    list: {
        width: 250,
    },
    links: {
        textDecoration: 'none',
    },
    menuHeader: {
        paddingLeft: '30px'
    }
});

class MenuBar extends Component {
    constructor(props) {
        super(props);
        this.state = {
            component: null,
            open: false
        }
    }

    handleClick(item) {
        this.setState(prevState => (
            {[item]: !prevState[item]}
        ))
    }

    handleDrawerOpen = (e) => {
        this.setState(
            {open: !this.state.open}
        );
    };

    componentWillReceiveProps(nextProps) {
        this.setState({componet: nextProps.componet});
    }


    handler(children) {
        const {classes} = this.props;
        const {state} = this;
        return children.map((subOption) => {
            if (!subOption.children) {
                return (
                    <div key={subOption.name}>
                        <ListItem
                            button
                            key={subOption.name}>
                            <Link
                                to={subOption.url}
                                className={classes.links}>
                                <ListItemText
                                    inset
                                    primary={subOption.name}
                                />
                            </Link>
                        </ListItem>
                    </div>
                )
            }
            return (
                <div key={subOption.name}>
                    <ListItem
                        button
                        onClick={() => this.handleClick(subOption.name)}>
                        <ListItemText
                            inset
                            primary={subOption.name}/>
                        {state[subOption.name] ?
                            <ExpandLess/> :
                            <ExpandMore/>
                        }
                    </ListItem>
                    <Collapse
                        in={state[subOption.name]}
                        timeout="auto"
                        unmountOnExit
                    >
                        {this.handler(subOption.children)}
                    </Collapse>
                </div>
            )
        })
    }

    render() {
        const {classes} = this.props;
        const {open} = this.state;
        return (
            <div className={classes.root}>
                <CssBaseline/>
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
                            onClick={this.handleDrawerOpen}
                            edge="start"
                            className={clsx(classes.menuButton, open && classes.hide)}
                        >
                            <MenuIcon/>
                        </IconButton>
                        <Typography variant="h6" noWrap>
                            Persistent drawer
                        </Typography>
                    </Toolbar>
                </AppBar>


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
                            <IconButton onClick={this.handleDrawerOpen}>
                                {open ? <ChevronLeftIcon/> : <ChevronRightIcon/>}
                            </IconButton>
                        </div>
                        <div>
                            <List>
                                <ListItem
                                    key="menuHeading"
                                    divider
                                    disableGutters
                                >
                                    <ListItemText
                                        className={classes.menuHeader}
                                        inset
                                        primary="Nested Menu"
                                    />
                                </ListItem>
                                {this.handler(menuItems.data)}
                            </List>
                        </div>
                    </Drawer>
                </div>
                <main
                    className={clsx(classes.content, {
                        [classes.contentShift]: !open,
                    })}
                    style={{

                    }}
                >
                    <div className={classes.drawerHeader}/>
                    <Container maxWidth="lg" className={classes.container}>
                        <Switch>
                            <Route path="/admin/dashboard" exact component={Dashboard}/>
                        </Switch>
                        <Switch>
                            <Route path="/admin/dashboard/Permission" exact component={Permissions}/>
                        </Switch>
                        <Switch>
                            <Route path="/admin/dashboard/business/natures" exact component={businessNature}/>
                        </Switch>
                        <Switch>
                            <Route path="/admin/dashboard/business/situations" exact component={businessSituation}/>
                        </Switch>
                        <Switch>
                            <Route path="/admin/dashboard/folderTech/natures" exact component={folderTechNature}/>
                        </Switch>
                        <Switch>
                            <Route path="/admin/dashboard/folderTech/situations" exact component={folderTechSituation}/>
                        </Switch>
                        <Switch>
                            <Route path="/admin/dashboard/customerRelationship/intermediate" exact component={intermediate}/>
                        </Switch>
                        <Switch>
                            <Route path="/admin/dashboard/customerRelationship/client" exact component={client}/>
                        </Switch>
                        <Switch>
                            <Route path="/admin/dashboard/business/business" exact component={business}/>
                        </Switch>

                    </Container>
                </main>
            </div>
        )
    }
}

export default withStyles(styles)(MenuBar)
