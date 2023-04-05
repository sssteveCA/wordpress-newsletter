import { NlUnsubscribeUserData } from "../types/types.js";
import { Languages } from "../enums/enums.js";
import { Constants } from "../namespaces/constants.js";
import { Messages } from "../namespaces/messages.js";
import { clientGet } from "../config/axios_instances.js";
import { AxiosStatic } from "../../node_modules/axios/index.js";

declare const axios: AxiosStatic;

export class UnsubscribeUser{

    private _lang: string;
    private _unsubscribe_code: string;
    private _errno: number = 0;
    private _error: string|null = null;

    public static ERR_FETCH: number = 1;

    private static ERR_FETCH_MSG: string = Messages.ERR_UNSUBSCRIBE_USER;

    private static FETCH_URL: string = Constants.PLUGIN_DIR+"/scripts/subscribe/unsubscribe.php";

    constructor(data: NlUnsubscribeUserData){
        if(data.lang)
            this._lang = data.lang;
        else
            this._lang = Languages.EN;
        this._unsubscribe_code = data.unsubscribe_code;
    }

    get lang(){ return this._lang}
    get unsubscribe_code(){ return this._unsubscribe_code}
    get errno(){ return this._errno; }
    get error(){
        switch(this._errno){
            case UnsubscribeUser.ERR_FETCH:
                this._error = UnsubscribeUser.ERR_FETCH_MSG;
                break;
            default:
                this._error = null;
                break;
        }
        return this._error;
    }

    public async unsubscribe(): Promise<object>{
        let response: object = {};
        this._errno = 0;
        try{
            await this.unsubscribePromise().then(res => {
                //console.log(res);
                response = JSON.parse(res);
            }).catch(err => {
                throw err;
            })
        }catch(e){
            if(e instanceof axios.AxiosError){
                const stringError: string = e.response?.data;
                //console.log(stringError);
                response = JSON.parse(stringError);
            }
            else{
                this._errno = UnsubscribeUser.ERR_FETCH;
                response = { done: false, msg: this.error }
            }        
        }
        return response;
    }

    private async unsubscribePromise(): Promise<string>{
        let url = `${UnsubscribeUser.FETCH_URL}?lang=${this._lang}&unsubscCode=${this._unsubscribe_code}&ajax=1`
        return await new Promise<string>((resolve,reject)=>{
            clientGet.get(url).then(res => {
                resolve(res.data)
            })
            .catch(err => {
                reject(err)
            })
        })
    }
}