import { GetSubscriber } from "../types/types";
import { Constants } from "../namespaces/constants";


/**
 * Get the users subscribed to the newsletter
 */
export default class GetSubscribers{

    private _subscribers: GetSubscriber[];
    private _errno: number = 0;
    private _error: string|null = null;

    public static ERR_FETCH: number = 1;

    private static ERR_FETCH_MSG: string = "Errore durante l'esecuzione della richiesta";

    private static FETCH_URL: string = Constants.PLUGIN_DIR+"/scripts/emailsending/getsubscribers.php";

    constructor(){

    }

    get errno(){return this._errno;}
    get error(){
        switch(this._errno){
            case GetSubscribers.ERR_FETCH:
                this._error = GetSubscribers.ERR_FETCH_MSG;
                break;
            default:
                this._error = null;
                break;
        }
        return this._error;
    }

}