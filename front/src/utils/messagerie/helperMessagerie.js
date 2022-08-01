import {isEmpty} from "../../utils";

export function getIdFromRoute(id, conversations) {
    let idRoute = !id ?
        !isEmpty(conversations) ?
            conversations[Object.keys(conversations)[0]].id ?
                conversations[Object.keys(conversations)[0]].id : id : id
        : id;
    return idRoute;
}
