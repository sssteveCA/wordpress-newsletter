
import { AxiosStatic } from "../../node_modules/axios/index.js";
import { clientPost } from "../config/axios_instances.js";
import { Constants } from "../namespaces/constants.js";
import { NlFormDataDelete } from "../types/types.js";

declare const axios: AxiosStatic;

export default class DeleteUsers{
    private _emails: string[];
    private _errno: number = 0;
    private _error: string|null = null;

    public static ERR_FETCH: number = 1;

    private static ERR_FETCH_MSG: string = "Errore durante l'invio della mail";

    private static FETCH_URL: string = Constants.HOME_URL+Constants.PLUGIN_DIR+"/scripts/subscribe/delete_user.php";

    constructor(data: NlFormDataDelete){
        this._emails = data.emails;
    }

    get emails(){ return this._emails; }
    get errno(){return this._errno;}
    get error(){
        switch(this._errno){
            case DeleteUsers.ERR_FETCH:
                this._error = DeleteUsers.ERR_FETCH_MSG;
                break;
            default:
                this._error = null;
                break;
        }
        return this._error;
    }

    public async deleteUsers(): Promise<object>{
        this._errno = 0;
        let response: object = {};
        try{
            await this.deleteUsersPromise().then(res => {
                console.log(res);
                response = JSON.parse(res);
            }).catch(err => {
                throw err;
            });
        }catch(e){
            if(e instanceof axios.AxiosError){
                const stringError: string = e.response?.data;
                response = JSON.parse(stringError);
            }
            else{
                this._errno = DeleteUsers.ERR_FETCH;
                response = {done: false, msg: this.error};
            }  
        }
        return response;
    }

    private async deleteUsersPromise(): Promise<string>{
        return await new Promise<string>((resolve, reject)=>{
            clientPost.post(DeleteUsers.FETCH_URL,{
                emails: this._emails
            }).then(res => {
                resolve(res.data);
            }).catch(err => {
                reject(err);
            });
        });
    }
}