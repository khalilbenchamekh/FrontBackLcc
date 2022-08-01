import _ from 'underscore';
import { months } from "../Constansts/file";

export function toShortFormat() {
    let current_datetime = new Date();
    let formatted_date = current_datetime.getDate() + "-" + months[current_datetime.getMonth()] + "-" + current_datetime.getFullYear();
    return formatted_date;
}

export function formaDate(date) {
    var d = new Date(date),
        month = '' + (d.getMonth() + 1),
        day = '' + d.getDate(),
        year = d.getFullYear();

    if (month.length < 2) month = '0' + month;
    if (day.length < 2) day = '0' + day;

    return [year, month, day].join('/');
}

export function explodStringFromDate(date) {
    let splieDate = date.split('-');
    if (splieDate) {
        if (splieDate.length === 3) {
            let m = splieDate[1];
            if (m) {
                let index = _.indexOf(months, m);
                if (index !== -1) {
                    index = index + 1;
                    return splieDate[2] + '-' + index + '-' + splieDate[0];
                }
            }
        }
    }
    return date;
}
