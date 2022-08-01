import React, {Component} from "react";
import ReactMapboxGl, {Marker, Popup, ZoomControl,} from "react-mapbox-gl";
import {connect} from "react-redux";
import styled from 'styled-components';
import _ from "underscore";
import {
    accessToken,
    scrollZoom,
    minZoom,
    maxZoom,
    mapboxZoom,
    mapStyle,
    longitude,
    latitude, city
} from "../../../Constansts/map";
let adrInit= {longitude: longitude, latitude: latitude, city: city, zoom: mapboxZoom};

const Map = ReactMapboxGl({
    minZoom: minZoom,
    maxZoom: maxZoom,
    scrollZoom: scrollZoom,
    accessToken: accessToken
});

const StyledPopup = styled.div`
  background: white;
  color: #3f618c;
  font-weight: 400;
  padding: 5px;
  border-radius: 2px;
`;

export class MapBox extends Component {

    constructor(props) {
        super(props);
        this.state = {
            popupLocation:undefined
        };
    }
    markerClick = (station, {marker}) => {
        this.setState({  popupLocation: {coor :station.coor,
            membership_type:station.membership_type
        }
        });
    };

    render() {
        const{
            popupLocation
        }=this.state;
        const {
            data,
            adr
        } = this.props;
        let map = null;
        if (_.isArray(data)) {

            map = data.map((Info, Key) => (

                    <Marker key={Key}
                            anchor={"bottom-left"}
                            onClick={this.markerClick.bind(this, {
                                coor: {lat: Info.longitude, lng: Info.latitude},
                                membership_type:Info.membership_type
                            })}

                            coordinates={{

                             lat: Info.longitude,
                                lng: Info.latitude
                            }}
                    >
                        <div className="mapMarkerStyle">
                            <div className="Number"/>
                        </div>
                        <div className='pulse'/>

                    </Marker>
                )
            )
        }
        return (

        <>
            { _.isMatch(adr, adrInit)===false ? <Map
                style={mapStyle}
                center={{lat: adr.latitude, lng: adr.longitude}}
                zoom={mapboxZoom}

                className='map-box-home'
            >
                <ZoomControl position="bottom-left"/>
                {map}
                {
                    popupLocation && (
                            <Popup  coordinates={popupLocation.coor}>
                                <StyledPopup>
                                    <div className="colorTextPopUp">
                                        {popupLocation.membership_type}
                                    </div>
                                </StyledPopup>
                            </Popup>
                    )}
            </Map> :null


            }

        </>



        );
    }


}

const mapDispatchToProps = {};


function mapStateToProps(state) {
    return {
        adr: state.locations.adr,
        data: state.locations.locations
    };
}

export default connect(mapStateToProps, mapDispatchToProps)(MapBox);
