import { downloadFileExplorer, fileExplorer } from "../../Env/env";
import { downloadManager } from "../../utils/downloadManager";

export const downloadFileFromService = (payload) => {
    let ajaxSettings = payload.payload.ajaxSettings;
    let data = ajaxSettings.data;
    let method = 'POST';
    let token = payload.payload.token;
    let body = JSON.stringify(data);
    if (data.data[0]) {
        let filename = data.data[0].name;
        let type = data.data[0].isFile
        if (type === true) {
            return downloadManager(downloadFileExplorer, body, method, token, filename, true);
        }
    }
}
