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

    private static FETCH_URL: string = Constants.PLUGIN_DIR+"/scripts/browser/emailsending/getnewsletterlog.php";

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
}