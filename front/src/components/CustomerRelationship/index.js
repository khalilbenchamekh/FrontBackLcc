import React, {Component} from 'react';

import Intermediate from './intermediate/index'
import Client from './client/index'

class Permissions extends Component {
    constructor(props, context) {
        super(props, context);
     
    }

  
    render() {

        return (

            <div className='container divEx1'>
                <Intermediate />
                <Client/>
            </div>

        )
    }
}



export default Permissions;
