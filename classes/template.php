<?php

namespace Newsletter\Classes;

use Newsletter\Enums\Langs;
use Newsletter\Classes\Properties;

class Template{

    /**
     * Newsletter HTML body
     */
    public static function mailTemplate(array $params): string{
        $messages = [];
        $htmlTemplate = <<<HTML
<!DOCTYPE html>
<html lang="it">
    <head>
        <title>{$params['title']}</title>
        <!-- <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"> -->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="format-detection" content="address=no, date=no, email=no, telephone=no">
        <meta charset="utf-8">
        <style>
        </style>
    </head>
    <body style="display: flex; flex-direction: column; justify-content: center; align-items: center; max-width: 650px;">
        <table id="tContent" class="full-width" style="width: 100%; border: none;">
            <thead>
                <th colspan="3">
                    <h1></h1>
                </th>
            </thead>
            <tbody>
                <!-- Testo messaggio -->
                <tr class="text">
                    <td colspan="3" style="padding: 5px 20px 20px 20px; text-align: center; font-size: 20px;">
                        <div style="font-family:arial,sans-serif !important; font-size: 20px !important; font-style: italic !important; text-align: justify !important;">
                        {$params['text']}
                        </div>
                    </td>
                </tr>
                <!-- Testo Social -->
                <tr>
                    <td colspan="3" style="padding: 20px 20px 10px 20px; text-align: center;">
                        <strong style="font-size: 14px;"></strong>
                    </td>
                </tr>
                <!-- Link social -->
                <tr>
                    <td colspan="1" style="padding:20px;">
                        <a title ="Facebook" href="https://www.facebook.com/Biancalabambinadeisogni/" target="_blank">
                            <img id="imgFacebook" class="img" style="display: block; margin: auto; height: 45px; width: 45px;" src="{$params['facebookLogo']}" alt="Facebook" title="Facebook">
                        </a>
                    </td>
                    <td colspan="1" style="padding:20px;">
                        <a title="Instagram" href="https://www.instagram.com/lafilosofiadibianca/" target="_blank">
                            <img id="imgInstagram" class="img" style="display: block; margin: auto; height: 45px; width: 45px;" src="{$params['instagramLogo']}" alt="Instagram" title="Instagram">
                        </a>
                    </td>
                    <td colspan="1" style="padding:20px;">
                        <a title="Youtube" href="https://www.youtube.com/channel/UCVvGeKjn52OHK1j1IfwCrEQ" target="_blank">
                            <img id="imgYoutube" class="img" style="display: block; margin: auto; height: 45px; width: 45px;" src="{$params['youtubeLogo']}" alt="Youtube" title="Youtube"> 
                        </a>
                    </td>
                </tr>
                <!-- Footer -->
                <tr>
                    <td colspan="3" style="padding: 20px; font-size: 14px;">
                        {$messages[1]}<br>
                        {$messages[2]}
                    </td>
                </tr>
                <tr style="background-color: rgba(14, 238, 144, 0.5);">
                    <td colspan="3" style="padding:20px; text-align: center;">{$messages[3]}</td>
                </tr>
            </tbody>
        </table>
    </body>
</html>
HTML;
        return $htmlTemplate;
    }

    /**
     * Messages to add at Mail HTML template
     */
    public static function mailTemplateMessages(Langs $lang, array $params): array{
        $home_url = Properties::homeUrl();
        $privacy_url = Properties::privacyUrl($lang);
        $contacts_url = Properties::contactsUrl($lang);
        if($lang->value == "it"){
            return [
                0 => 'Siamo presenti anche su questi social network',
                1 => '<div>Ricevi questa comunicazione perché ti sei iscritto/a al servizio di newsletter di <a href="'.$home_url.'">La filosofia di Bianca</a> con l\'indirizzo e-mail <a href="#" style="pointer-events: none; cursor: text; text-decoration: none; color: black;"><strong>'.$params['user_email'].'</strong></a></div>',
                2 => '<div style="margin-top: 10px;">Puoi consultare <a href="'.$privacy_url.'" target="_blank" title="Privacy">qui</a> la nostra informativa sulla privacy.<br>Per ulteriori informazioni sui tuoi dati personali, contattaci a questo <a href="'.$contacts_url.'" target="_blank" title="Contattaci">link</a></div>',
                3 => 'Puoi cancellare l\'iscrizione facendo <a href="'.$params['unsubscribe_url'].'" title="Cancella iscrizione" target="_blank">click qui</a>'
            ];
        }
        else if($lang->value == "es"){
            return [
                0 => 'También estamos presentes en estas redes sociales',
                1 => '<div>Recibe esta comunicación porque se ha suscrito al servicio de newsletter de <a href="'.$home_url.'">La filosofia di Bianca</a> con con la dirección de correo electrónico <a href="#" style="pointer-events: none; cursor: text; text-decoration: none; color: black;"><strong>'.$params['user_email'].'</strong></a></div>',
                2 => '<div style="margin-top: 10px;">Puede consultar nuestra política de privacidad <a href="'.$privacy_url.'" target="_blank" title="Privacidad">aquí</a>.<br> Para obtener más información sobre sus datos personales, contáctenos en este <a href="'.$contacts_url.'" target="_blank" title="Contáctenos">enlace</a></div>',
                3 => 'Puede darse de baja haciendo <a href="'.$params['unsubscribe_url'].'" title="Darse de baja" target="_blank">clic aquí</a>'
            ];
        }
        else{
            return [
                0 => 'We are also present on these social networks',
                1 => '<div>You receive this communication because you have subscribed to the <a href="'.$home_url.'">La filosofia di Bianca</a>\'s newsletter service with the email address <a href="#" style="pointer-events: none; cursor: text; text-decoration: none; color: black;"><strong>'.$params['user_email'].'</strong></a></div>',
                2 => '<div style="margin-top: 10px;">You can consult our privacy policy <a href="'.$privacy_url.'" target="_blank" title="Privacy">here</a>.<br> For more information on your personal data, contact us at this <a href="'.$contacts_url.'" target="_blank" title="Contact us">link</a></div>',
                3 => 'You can unsubscribe by <a href="'.$params['unsubscribe_url'].'" title="Unsubscribe" target="_blank">clicking here</a>'
            ];
        }
    }
}
?>