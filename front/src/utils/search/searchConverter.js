import _ from 'underscore';
export function convertToObject(obj){
    let arr = [];
    _(obj).each(function(elem, key){
        console.log(elem);
        console.log(key);
        arr.push(elem);
    });
    return arr;
}

