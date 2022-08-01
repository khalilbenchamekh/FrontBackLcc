import * as types from "../index";
export const downloadFileAction=(token,ajaxSettings)=>{
    return {
        type: types.DOWNLOAD_FILE_TO_FILE_MANAGER,
        payload: {
            token: token, ajaxSettings
        }

    }
};
