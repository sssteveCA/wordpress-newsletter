
export default class User{
    public id: number;
    public firstName: string|null;
    public lastName: string|null;
    public email: string;
    public lang: string;
    public verCode: string|null;
    public unsubscCode: string|null;
    public subscribed: boolean;
    public subscDate: Date;
    public actDate: Date;
}