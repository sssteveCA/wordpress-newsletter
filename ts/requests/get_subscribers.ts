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

    public async getSubscribers(): Promise<object>{
        this._errno = 0;
        let response: object = {};
        try{
            await this.getSubscribersPromise().then(res => {
                console.log(res);
                response = JSON.parse(res);
                if(response["done"] == true){
                    this._subscribers = response["subscribers"];
                }
            }).catch(err => {
                throw err;
            });
        }catch(e){
            this._errno = GetSubscribers.ERR_FETCH;
            response = {
                done: false, msg: ""
            };
        }
        return response;
    }

    private async getSubscribersPromise(): Promise<string>{
        let promise = await new Promise<string>((resolve,reject)=>{
            fetch(GetSubscribers.FETCH_URL).then(res => {
                resolve(res.text());
            }).catch(err => {
                reject(err);
            });
        });
        return promise;
    }

}