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

    public sendNewsletter(): object{
        this.sendNewsletterLoop()
        return {
            message: 'Controlla tra qualche minuto nel file di log se la newsletter è stata inviata a tutti i destinatari'
        }
    }

    /**
     * Exceute the request for newsletter sending
     * @param emails the recipients of the newsletter
     * @returns the response
     */
    private async promise(emails: string[]): Promise<string>{
        return await new Promise<string>((resolve,reject)=>{
            clientPost.post(SendEmail.FETCH_URL,{
                emails: emails,
                subject: this._subject,
                body: this._message  
            }).then(res => {
                resolve(res.data);
            }).catch(err => {
                reject(err);
            });
        });
    }

    /**
     * The loop that execute the request multiple time for each rescipients group
     */
    private sendNewsletterLoop(): void{
        let sub_arr_lenght = 5
        let start = 0
        let end = sub_arr_lenght
        const iterations = (this._emails.length % 5 == 0) ? this._emails.length/5 : Math.floor(this._emails.length/5) + 1
        let counter = 1
        const interval = setInterval(()=>{
            let sub_arr = this._emails.slice(start,end)
            const res = this.promise(sub_arr)
            if(counter >= iterations) clearInterval(interval)
            start += sub_arr_lenght
            end += sub_arr_lenght
            counter++
        },3000)
    }


}