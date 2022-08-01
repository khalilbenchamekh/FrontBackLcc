import React, { Component } from 'react';
import { compose } from 'recompose';
import { withStyles, Modal, Fade } from '@material-ui/core';
import { connect } from 'react-redux';
import ReactCrop from 'react-image-crop';


import 'react-image-crop/dist/ReactCrop.css';
const style = (theme) => ({
    modal: {
        display: 'flex',
        alignItems: 'center',
        justifyContent: 'center',
    },
    paper: {
        backgroundColor: theme.palette.background.paper,
        border: '2px solid #000',
        boxShadow: theme.shadows[5],
        padding: theme.spacing(2, 4, 3),
        height: 540,
        width: 700
    },
    image: {
        height: 400,
        width: 400,
        background: "#00000044",
        "& img": {
            maxHeight: 400,
            maxWidth: 400
        },
        marginRight: "20px"
    },
    croppedImage: {
        height: 200,
        width: 200,
        background: "#00000044",
    },
    content: {
        display: "flex",
        flexDirection: "row",
        alignItems: "center"
    },
    controls: {
        width: "fit-content",
        display: "inline",
        float: "right"
    }
})
class ImageCropper extends Component {
    constructor() {
        super();
        this.state = {
            src: null,
            crop: {
                unit: '%',
                width: 30,
                aspect: 1,
            },
            fileResult: "",
        }
    }

    onSelectFile = e => {
        if (e.target.files && e.target.files.length > 0) {
            const reader = new FileReader();
            reader.addEventListener('load', () =>
                this.setState({ src: reader.result })
            );
            reader.readAsDataURL(e.target.files[0]);
        }
    };
    onImageLoaded = image => {
        this.imageRef = image;
    };

    onCropComplete = crop => {
        this.makeClientCrop(crop);
    };

    onCropChange = (crop, percentCrop) => {
        // You could also use percentCrop:
        // this.setState({ crop: percentCrop });
        this.setState({ crop });
    };



    async makeClientCrop(crop) {
        if (this.imageRef && crop.width && crop.height) {
            const croppedImageUrl = await this.getCroppedImg(
                this.imageRef,
                crop,
                'newFile.jpeg'
            );
            this.setState({ croppedImageUrl });
        }
    }

    getCroppedImg(image, crop, fileName) {
        const { onImageCropped } = this.props;
        const canvas = document.createElement('canvas');
        const scaleX = image.naturalWidth / image.width;
        const scaleY = image.naturalHeight / image.height;
        canvas.width = crop.width;
        canvas.height = crop.height;
        const ctx = canvas.getContext('2d');

        ctx.drawImage(
            image,
            crop.x * scaleX,
            crop.y * scaleY,
            crop.width * scaleX,
            crop.height * scaleY,
            0,
            0,
            crop.width,

            crop.height
        );


        return new Promise((resolve, reject) => {
            canvas.toBlob(blob => {
                if (!blob) {
                    console.error('Canvas is empty');
                    return;
                }
                blob.name = fileName;
                var reader = new FileReader();
                reader.readAsDataURL(blob);
                reader.onloadend = function () {
                    var base64data = reader.result;
                    onImageCropped(base64data)
                }

                window.URL.revokeObjectURL(this.fileUrl);
                this.fileUrl = window.URL.createObjectURL(blob);
                resolve(this.fileUrl);
            }, 'image/jpeg');
        });
    }
    handleChange = (input) => {
        this.setState({ ...input })
    }

    validate = () => {
        const { croppedImageUrl } = this.state;
        const { onValidate } = this.props
        onValidate && onValidate(croppedImageUrl)
    }

    render() {
        const { classes, open, onClose } = this.props;
        const { crop, croppedImageUrl, src } = this.state;
        console.log(open)
        return (
            <Modal
                aria-labelledby="transition-modal-title"
                aria-describedby="transition-modal-description"
                className={classes.modal}
                open={open}
                onClose={onClose}
                closeAfterTransition
                BackdropProps={{
                    timeout: 500,
                }}
            >
                <div className={classes.paper}>
                    <div className="mb-3 p-2 border-bottom">
                        <label for="input-file" className="btn btn-primary center">Choisre un {croppedImageUrl && "autre "}Fichier</label>
                        <div className={classes.controls}>
                            <button className="btn btn-dark center" onClick={onClose}>Annuler</button>
                            {croppedImageUrl && (<button className="btn btn-primary center ml-2" onClick={this.validate}>Valider</button>)}
                        </div>
                        <input id="input-file" className="collapse" type="file" accept="image/*" onChange={this.onSelectFile} />

                    </div>
                    <div className={classes.content}>
                        {(
                            <ReactCrop
                                className={classes.image}
                                src={src}
                                crop={crop}
                                onImageLoaded={this.onImageLoaded}
                                onComplete={this.onCropComplete}
                                onChange={this.onCropChange}
                            />
                        )}
                        {(
                            <img className={classes.croppedImage} style={{ maxWidth: '100%' }} src={croppedImageUrl} />
                        )}
                    </div>

                </div>

            </Modal>
        );
    }
}
const mapStateToProps = (state) => ({ ...state })
const dispatch = {}
export default compose(
    withStyles(style),
    connect(mapStateToProps, dispatch)
)(ImageCropper)
