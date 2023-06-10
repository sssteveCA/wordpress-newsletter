import { clientGet } from "../config/axios_instances";
import LogInfoItem from "../models/loginfoitem";
import { Constants } from "../namespaces/constants";

/**
 * Get the newsletter log info file
 */
export default class GetNewsletterLog{
    private _log: LogInfoItem[] = [];
    private _errno: number = 0;
    private _error: string|null = null;

    public static ERR_FETCH: number = 1;

    private static ERR_FETCH_MSG: string = "Impossibile leggere il file di log";

    private static FETCH_URL: string = Constants.PLUGIN_DIR+"/scripts/browser/log/getnewsletterlog.php";

    constructor(){}

    get log(){ return this._log; }
    get errno(){ return this._errno; }
    get error(){
        switch(this._errno){
            case GetNewsletterLog.ERR_FETCH:
                this._error = GetNewsletterLog.ERR_FETCH_MSG;
                break;
            default:
                this._error = null;
                break;
        }
         return this._error; 
    }

    public async getNewsletterLog(): Promise<object>{
        this._errno = 0;
        let response: object = {};
        try{
            await this.getNewsletterLogPromise().then(res => {
                console.log(res)
                response = JSON.parse(res)
                if(response[Constants.KEY_DONE] && !response[Constants.KEY_EMPTY])
                    this._log = response['loginfo']
            }).catch(err => {
                throw err;
            })
        }catch(e){
            this._errno = GetNewsletterLog.ERR_FETCH;
            response = { done: false, msg: this.error }
        }
        return response;
    }

    private async getNewsletterLogPromise(): Promise<string>{
        let promise = await new Promise<string>((resolve,reject)=>{
            clientGet.get(GetNewsletterLog.FETCH_URL)
                .then(res => resolve(res.data))
                .catch(err => reject(err));
        });
        return promise;
    }
}