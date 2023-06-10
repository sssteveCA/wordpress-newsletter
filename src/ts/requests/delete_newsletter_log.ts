import axios from "axios";
import { clientDelete } from "../config/axios_instances";
import { Constants } from "../namespaces/constants";

export default class DeleteNewsletterLog{

    private _errno: number = 0;
    private _error: string|null = null;

    public static ERR_FETCH: number = 1;

    private static ERR_FETCH_MSG: string = "Impossibile leggere il file di log";

    private static FETCH_URL: string = Constants.PLUGIN_DIR+"/scripts/browser/log/deletenewsletterlog.php";

    get errno(){ return this._errno; }
    get error(){
        switch(this._errno){
            case DeleteNewsletterLog.ERR_FETCH:
                this._error = DeleteNewsletterLog.ERR_FETCH_MSG;
                break;
            default:
                this._error = null;
                break;
        }
        return this._error;
    }

    public async deleteNewsletterLog(): Promise<object>{
        this._errno = 0
        let response: object = {}
        try{
            await this.deleteNewsletterLogPromise().then(res => {
                response = JSON.parse(res)
            }).catch(err => {
                throw err;
            })
        }catch(e){
            if(e instanceof axios.AxiosError){
                const stringError: string = e.response?.data;
                response = JSON.parse(stringError);
            }
            else{
                this._errno = DeleteNewsletterLog.ERR_FETCH;
                response = {done: false, msg: this.error};
            }  
        }
        return response
    }

    private async deleteNewsletterLogPromise(): Promise<string>{
        return await new Promise<string>((resolve,reject) => {
            clientDelete.delete(DeleteNewsletterLog.FETCH_URL)
                .then(res => resolve(res.data))
                .catch(err => reject(err))
        });
    }
}