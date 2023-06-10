import { Constants } from "../namespaces/constants";

export default class DeleteNewsletterLog{

    private _errno: number = 0;
    private _error: string|null = null;

    public static ERR_FETCH: number = 1;

    private static ERR_FETCH_MSG: string = "Impossibile leggere il file di log";

    private static FETCH_URL: string = Constants.PLUGIN_DIR+"/scripts/browser/log/getnewsletterlog.php";

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
}