import React, { Component } from 'react';
import { compose } from 'recompose';
import { withStyles, InputLabel, FormControl, Input, FormHelperText, Button } from '@material-ui/core';
import { connect } from 'react-redux';
import ImageCropper from './ImageCropper';
import {setUsersWithPermissionsAction} from "../../actions/adminActions";
import {setProfileAction} from "../../actions/profileActions";
import {deleteCookie, getCookie} from "../../utils/cookies";
import _ from 'underscore';
import {Modal, Fade} from '@material-ui/core';
import ReactCrop from 'react-image-crop';


import profileBackup from '../../assets/profile_backup.png'

const style = (theme) => ({
    root: {
        display: "flex",
        flexDirection: "column",
        height: "88vh"
    },
    image: {
        display: "flex",
        flexDirection: "column",
        flexBasis: 200,
        maxHeight: 200,
        margin: "15px 10px"
    },
    imageCrop: {
        width: 200,
        height: 200,
        overflow: "hidden",
        borderRadius: 200,
        objectFit: "contain",
        margin: "auto",
        cursor: 'pointer',
        backgroundColor: "#ffffff",
        border: "solid 2px #222928"
    },
    imageImg: {
        height: "100%",
        cursor: "pointer"
    },
    infos: {
        flexGrow: 1,
        display: "flex",
        flexDirection: "column",
        margin: "5px 10px 15px 10px",
        padding: "15px 30px"
    },
    inputGroup: {
        marginBottom: 10,
    },
    details: {
        padding: "15px 30px",
        display: "flex",
        flexDirection: "column",
        background: "#ffffff",
        borderRadius: 5
    },
    input: {
        color: "black !important",
        fontWeight: "500"
    }
});

class Profile extends Component {
    constructor() {
        super();
        this.state = {
            avatar: undefined,
            firstname: "",
            middlename: "",
            lastname: "",
            birthdate: "",
            address: "",
            disabled: true,
            open: false,
            old: {},
            fileResult: undefined
        }
    }

    handleChange = (input) => {
        this.setState({ ...input })
    }

    handleSubmit = () => {
        let token = this.props.token === "" ? getCookie("token") : this.props.token;
        let formdata = new FormData();
        let avatar = this.state.fileResult;
        if (avatar) {
            formdata.append('avatar', avatar);
        }
        formdata.append('name', this.state.name);
        formdata.append('email', this.state.email);
        formdata.append('firstname', this.state.firstname);
        formdata.append('middlename', this.state.middlename);
        formdata.append('lastname', this.state.lastname);
        formdata.append('birthdate', this.state.birthdate);
        formdata.append('address', this.state.address);
        this.props.setProfileAction(token, formdata);
    }

    componentWillReceiveProps(nextProps, nextContext) {
        if (_.isEqual(this.props.data, nextProps.data)) {
            if (nextProps.data) {
                let data = nextProps.data;
                this.setState({
                    avatar: data.avatar,
                    email: data.email,
                    name: data.name,
                    firstname: data.firstname,
                    middlename: data.middlename,
                    lastname: data.lastname,
                    birthdate: data.birthdate,
                    address: data.address,
                    disabled: false
                });
            }
        }

    }

    updateImageFileState = (base64data) => {
        this.setState({ fileResult: base64data }, () => console.log(this.state));
    }

    render() {
        const { classes } = this.props;
        const {
            avatar,
            email,
            name,
            firstname,
            middlename,
            lastname,
            birthdate,
            address,
            disabled, open, old
        } = this.state;

        const {crop, croppedImageUrl, src} = this.state;
        return (
            <div className={classes.root}>
                <div className={classes.image}>
                    <div className={classes.imageCrop}
                        onClick={() => this.handleChange({ open: true })}
                    >
                        <img
                            className={classes.imageImg}
                            src={avatar || profileBackup}
                            onError={() => this.handleChange({ avatar: profileBackup })}
                        />
                    </div>
                </div>
                <div className={classes.infos}>
                    <div className={classes.details}>
                        {/* First Name */}
                        <FormControl className={classes.inputGroup}>
                            <InputLabel htmlFor="my-input">Nom</InputLabel>
                            <Input
                                className={classes.input}

                                value={firstname}
                                onChange={(e) => this.handleChange({ firstname: e.target.value })}
                            />
                        </FormControl>

                        <FormControl className={classes.inputGroup}>
                            <InputLabel htmlFor="my-input">name</InputLabel>
                            <Input
                                className={classes.input}
                                value={name}
                                onChange={(e) => this.handleChange({ name: e.target.value })}
                            />
                        </FormControl>
                        <FormControl className={classes.inputGroup}>
                            <InputLabel htmlFor="my-input">email</InputLabel>
                            <Input
                                className={classes.input}
                                disabled={true}
                                value={email}
                                onChange={(e) => this.handleChange({ email: e.target.value })}
                            />
                        </FormControl>
                        {/* Last Name */}
                        <FormControl className={classes.inputGroup}>
                            <InputLabel htmlFor="my-input">Prenom</InputLabel>
                            <Input
                                className={classes.input}
                                value={lastname}
                                onChange={(e) => this.handleChange({ lastname: e.target.value })}
                            />
                        </FormControl>
                        <FormControl className={classes.inputGroup}>
                            <InputLabel htmlFor="my-input">middlename</InputLabel>
                            <Input
                                className={classes.input}
                                value={middlename}
                                onChange={(e) => this.handleChange({ middlename: e.target.value })}
                            />
                        </FormControl>
                        {/* Age */}
                        <FormControl className={classes.inputGroup}>
                            <InputLabel htmlFor="my-input">Date</InputLabel>
                            <Input
                                className={classes.input}
                                value={birthdate}
                                onChange={(e) => this.handleChange({ birthdate: e.target.value })}
                            />
                        </FormControl>
                        {/* Phone Number */}
                        <FormControl className={classes.inputGroup}>
                            <InputLabel htmlFor="my-input">address</InputLabel>
                            <Input
                                className={classes.input}
                                value={address}
                                onChange={(e) => this.handleChange({ address: e.target.value })}
                            />
                        </FormControl>
                        <div>
                            {
                                // disabled ? (
                                //     <button className="btn btn-primary float-right" onClick={() => this.handleChange({
                                //         disabled: false,
                                //         old: {...this.state}
                                //     })}>Modifier</button>
                                // ) : (
                                //
                                <>
                                    <button className="btn btn-primary float-right mr-auto"
                                        onClick={this.handleSubmit}>Valider
                                        </button>
                                    <button className="btn btn-dark float-right mr-2"
                                        onClick={() => this.handleChange({ ...old })}>Annuler
                                        </button>
                                </>
                                // )
                            }


                            <ImageCropper
                                open={open}
                                onClose={() => this.handleChange({ open: false })}
                                onValidate={(src) => this.handleChange({ avatar: src, open: false })}
                                onImageCropped={this.updateImageFileState}
                            />
                        </div>
                    </div>
                </div>
            </div>
        );
    }
}

const mapDispatchToProps = {
    setProfileAction

};


function mapStateToProps(state) {
    return {
        data: state.login.data,
        token: state.login.token,

    };
}

export default compose(
    withStyles(style, {
        name: 'Profile',
    }),
    connect(mapStateToProps, mapDispatchToProps),
)(Profile);

