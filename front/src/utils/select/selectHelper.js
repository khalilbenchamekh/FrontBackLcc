import { i_need_name, tvaConst } from "../../Constansts/selectHelper";
import _ from "underscore";

export function selectHelper(response, valueNeeded) {
    let arrayTemp = [];
    for (let i = 0; i < response.length; i++) {
        let obj = {};
        obj = {
            value:
                valueNeeded === "id" ?
                    response[i].id :
                    response[i].name
            , label: response[i].name
        };
        if (obj !== {}) {
            arrayTemp.push(obj);
        }
    }
    return arrayTemp;
}

export function complexHelper(response, valueNeeded, key) {
    let arrayTemp = [];
    for (let i = 0; i < response.length; i++) {
        let obj = {};
        obj = {
            value: valueNeeded === "id" ?
                response[i].id :
                response[i][key]
            , label: response[i][key]
        };
        if (obj !== {}) {
            arrayTemp.push(obj);
        }
    }
    return arrayTemp;
}

export function selectTvaHelper() {
    let arrayTemp = [];
    let response = tvaConst;
    for (let i = 0; i < response.length; i++) {
        let obj = {};
        obj = {
            value:
                response[i].value
            , label: response[i].label
        };
        if (obj !== {}) {
            arrayTemp.push(obj);
        }
    }
    return arrayTemp;
}

export function findItemInArray(array, value, lookingFor) {
    return _.find(array, function (o) {
        return lookingFor === i_need_name ?
            o.label === value :
            o.value === value
    });
}

export function selectIceSelect(response) {
    let arrayTemp = [];
    for (let i = 0; i < response.length; i++) {
        let obj = {};
        obj = {
            value:
                response[i].ICE
            , label: response[i].name,
        };
        if (obj !== {}) {
            arrayTemp.push(obj);
        }
    }
    return arrayTemp;
}

export function selectFromConst(response) {
    let arrayTemp = [];
    for (let i = 0; i < response.length; i++) {
        let obj = {};
        obj = {
            value:
                response[i]
            , label: response[i],
        };
        if (obj !== {}) {
            arrayTemp.push(obj);
        }
    }
    return arrayTemp;
}
