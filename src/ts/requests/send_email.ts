import axios from 'axios';
import { clientPost } from "../config/axios_instances";
import { Constants } from "../namespaces/constants";
import { NlFormDataSend } from "../types/types";


export default class SendEmail{

    private _emails: string[];
    private _subject: string;
    private _message: string;
    private _errno: number = 0;
    private _error: string|null = null;

    public static ERR_FETCH: number = 1;

    private static ERR_FETCH_MSG: string = "Errore durante l'invio della mail";

    private static FETCH_URL: string = Constants.PLUGIN_DIR+"/scripts/emailsending/sendmail.php";

    constructor(data: NlFormDataSend){
        this.assignValues(data);
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

    private assignValues(data: NlFormDataSend): void{
        this._emails = data.emails;
        this._subject = data.subject;
        this._message = data.message;
    }

    public async sendEmail(): Promise<object>{
        this._errno = 0;
        let response: object = {};
        try{
            await this.sendEmailPromise().then(res => {
                //console.log(res);
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
                this._errno = SendEmail.ERR_FETCH;
            response = {done: false, msg: this.error}
            }
        }
        return response;
    }

    private async sendEmailPromise(): Promise<string>{
        return await new Promise<string>((resolve,reject)=>{
            clientPost.post(SendEmail.FETCH_URL,{
                emails: this._emails,
                subject: this._subject,
                body: this._message  
            }).then(res => {
                resolve(res.data);
            }).catch(err => {
                reject(err);
            });
        });
    }
}