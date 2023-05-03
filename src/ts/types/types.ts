
export type BsCdDialogData = {
    title: string;
    message: string;
    btYesText?: string;
    btNoText?: string;
}

export type BsMdDialogData = {
    title: string;
    message: string;
    btOkText?: string;
}

/**
 * Single subscriber getted from subscribers array (with getsubscribers.php)
 */
export type GetSubscriber = {
    email: string;
    lang: string;
}

/**
 * Newsletter subscribe form values
 */
export type NlFormData = {
    name?: string;
    surname?: string;
    email: string;
    cb_privacy: string;
    cb_terms: string;
    lang: string;
};

/**
 * Newsletter subscribe form elements
 */
export type NlFormDataElements = {
    name: HTMLInputElement;
    surname: HTMLInputElement;
    email: HTMLInputElement;
    cb_privacy: HTMLInputElement;
    cb_terms: HTMLInputElement;
    lang: HTMLInputElement;
    bt_submit: HTMLButtonElement;
}

export type NlFormDataAdd = {
    name?: string;
    surname?: string;
    email: string;
    lang_code: string;
};

export type NlFormDataDelete = {
    emails: string[];
}

export type NlFormDataSend = {
    subject: string;
    message: string;
    emails: string[];
};

/**
 * HTML Settings form items references for FormDataSettingsHtml class
 */
export type NlFormDataSettings = {
    container_langs: HTMLDivElement;
    cb_langs: NlFormDataSettingsInputLangs;
    container_pages_enabled: HTMLDivElement;
    cb_pages_enabled: NlFormDataSettingsInputPagesEnabled;
    cb_social: NlFormDataSettingsInputSocial;
    row_social_links: HTMLDivElement;
    input_social_links: NlFormDataSettingsInputSocial;
    container_contacts_pages: HTMLDivElement;
    input_contacts_pages: NlFormDataSettingsInputLangs;
    container_privacy_pages: HTMLDivElement;
    input_privacy_policy_pages: NlFormDataSettingsInputLangs;
    buttons: NlFormDataSettingsButtons;
}

/**
 * Type needed by FormDataSettingsSetHtml class to manipulate the DOM depending on the settings data received
 */
export type NlFormDataSettingsSet = {
    data: NlSettingsData;
} & Omit<NlFormDataSettings,"buttons">

/**
 * The data of the admin settings form to send to the server
 */
export type NlFormPostDataSettings = {
    facebook_page: string|null;
    instagram_page: string|null;
    youtube_page: string|null;
    contacts_page_it: string|null;
    contacts_page_es: string|null;
    contacts_page_en: string|null;
    privacy_policy_page_it: string|null;
    privacy_policy_page_es: string|null;
    privacy_policy_page_en: string|null;
}

export type NlFormDataSettingsInputPagesEnabled = {
    contacts_pages: HTMLInputElement;
    privacy_policy_pages: HTMLInputElement;
}

export type NlFormDataSettingsInputLangs = {
    lang_it: HTMLInputElement;
    lang_es: HTMLInputElement;
    lang_en: HTMLInputElement;
}

export type NlFormDataSettingsInputSocial = {
    facebook: HTMLInputElement;
    instagram: HTMLInputElement;
    youtube: HTMLInputElement;
}

export type NlFormDataSettingsButtons = {
    primary: HTMLButtonElement;
}

export type NlLanguages = {
    en?: boolean|string;
    es?: boolean|string;
    it?: boolean|string;
}

/**
 * This object contains the settings properties getted from the DB
 */
export type NlSettingsData = {
    lang_status: NlLanguages,
    included_pages_status: {
        contacts_pages: boolean, privacy_policy_pages: boolean
    },
    socials_status: NlSocials,
    social_pages: NlSocials,
    contact_pages: NlLanguages,
    privacy_policy_pages: NlLanguages
}

export type NlSocials = {
    facebook?: boolean|string;
    instagram?: boolean|string;
    youtube?: boolean|string;
}

export type NlUnsubscribeUserData = {
    lang?: string;
    unsubscribe_code: string;
}