
export type NlFormData = {
    email: string;
    cb_privacy: string;
    cb_terms: string;
    lang: string;
};

export type NlFormDataAdd = {
    email: string;
    lang_code: string;
    unsubcribe_code: string;
};

export type NlFormDataDelete = {
    emails: string[];
}

export type NlFormDataSend = {
    subject: string;
    message: string;
    emails: string[];
};