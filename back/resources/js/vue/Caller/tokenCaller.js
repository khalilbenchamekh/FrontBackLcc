import axios from "axios";
import {SERVER} from "../../server";

export const getToken= async (data) => {
    let res = await axios.post(SERVER + '/api/connexion', data);
    if(res){
        if(res.data){
            const token =  res.data.token;
            return token;
        }
    }
    return null;
}
