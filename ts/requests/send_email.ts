import { Constants } from "../namespaces/constants";
import { NlFormDataSend } from "../types/types";


export default class SendEmail{

    private _emails: string[];
    private _subject: string;
    private _message: string;
    private _errno: number = 0;
    private _error: string|null = null;

    public static ERR_FETCH: number = 1;

    private static ERR_FETCH_MSG: string = "Errore durante l'esecuzione della richiesta";

    private static FETCH_URL: string = Constants.HOME_URL+Constants.PLUGIN_DIR+"/scripts/emailsending/getsubscribers.php";

    constructor(data: NlFormDataSend){

    }

    get emails(){return this._emails;}
    get subject(){return this._subject;}
    get message(){return this._message;}
    get errno(){return this._errno;}
    get error(){
        switch(this._errno){
            case SendEmail.ERR_FETCH:
                this._error = SendEmail.ERR_FETCH_MSG;
                break;
            default:
                this._error = null;
                break;
        }
        return this._error;
    }
}