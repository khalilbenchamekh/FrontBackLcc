import {Url} from "../../Env/env";

function getFileNameFromHeader(header){
    var filename = "download.pdf";
    if(!header){

         var disposition = header.getResponseHeader('Content-Disposition');
    if (disposition && disposition.indexOf('attachment') !== -1) {
        var filenameRegex = /filename[^;=\n]*=((['"]).*?\2|[^;\n]*)/;
        var matches = filenameRegex.exec(disposition);
        if (matches != null && matches[1]) { 
          filename = matches[1].replace(/['"]/g, '');
        }
    }
    }
   
    return filename;
}

export function downloadManager(url, body, method, token, fileName,isJson=false) {


    let myHeaders = new Headers(); 

    myHeaders.append('Access-Control-Allow-Origin', '*');
    myHeaders.append('X-Requested-With', 'XMLHttpRequest');
    myHeaders.append('Access-Control-Allow-Methods', '*');
    myHeaders.append('Access-Control-Allow-Headers', '*');
    myHeaders.append('Authorization', 'Bearer ' + token,);
    if(isJson===true){
        myHeaders.append('Content-Type', 'application/json');
        myHeaders.append('Accept', 'application/json');
    }
    const parameters = {
        method: method,
        headers: myHeaders,
        Origin: Url,
        responseType: 'arraybuffer',
        body: body
    };
    return fetch(url, parameters)
        .then(async res => ({
            headers: res.headers,
            response:res,
            blob: await res.blob()
        }))
        .then(resObj => {
            // It is necessary to create a new blob object with mime-type explicitly set for all browsers except Chrome, but it works for Chrome too.
            let res = resObj.response;
            let status = res.status;
            if (status) {
                if (status !== 400 && status !== 401 && status !== 500) {
                    const newBlob = new Blob([resObj.blob], {type: resObj.headers.get('content-type')});

                    // MS Edge and IE don't allow using a blob object directly as link href, instead it is necessary to use msSaveOrOpenBlob
                    if (window.navigator && window.navigator.msSaveOrOpenBlob) {
                        window.navigator.msSaveOrOpenBlob(newBlob);
                    } else {
                        // For other browsers: create a link pointing to the ObjectURL containing the blob.
                        const objUrl = window.URL.createObjectURL(newBlob);

                        let link = document.createElement('a');
                        link.href = objUrl;
                        if(!fileName){
                            fileName= getFileNameFromHeader(resObj.headers);
                        }
                        link.download = fileName ;
                        link.click();

                        // For Firefox it is necessary to delay revoking the ObjectURL.
                        setTimeout(() => {
                            window.URL.revokeObjectURL(objUrl);
                        }, 250);
                    }
                }
            }
           

        }).catch((error) => {
            console.log('DOWNLOAD ERROR', error);
        });
}
