<?php

namespace Newsletter\Classes;

use Newsletter\Enums\Langs;
use Newsletter\Classes\Properties;

class Template{

    /**
     * Activation mail HTML body
     */
    public static function activationMailTemplate(string $lang, array $params): string{
        echo "template.php activationMailTemplate params => ".var_export($params,true)."\r\n";
        $title = Properties::activationMailTitle($lang);
        $clickLink = Properties::clickActivationLink($lang,$params['link']);
        $clickVerify = Properties::clickActivationLinkWithCode($lang,$params['verifyUrl'],$params['verCode']);
        $moreInfo = Properties::moreInformation($lang);
        $htmlTemplate = <<<HTML
<!DOCTYPE html>
<html lang="it">
    <head>
        <title>{$title}</title>
        <meta charset="utf-8">
    </head>
    <body>
    <p>{$clickLink}</p>
    <p>{$clickVerify}</p>
    <p>{$moreInfo}</p>
    </body>
</html>
HTML;
        return $htmlTemplate;
    }

    /**
     * Newsletter HTML body
     */
    public static function mailTemplate(string $lang, array $params): string{
        $facebookLogo = Properties::facebookLogoUrl();
        $facebookPage = Properties::facebookPageUrl();
        $instagramLogo = Properties::instagramLogoUrl();
        $instagramProfile = Properties::instagramProfileUrl();
        $youtubeChannel = Properties::youtubeChannelUrl();
        $youtubeLogo = Properties::youtubeLogoUrl();
        $messages = Template::mailTemplateMessages($lang,$params);
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
                        <a title ="Facebook" href="{$facebookPage}" target="_blank">
                            <img id="imgFacebook" class="img" style="display: block; margin: auto; height: 45px; width: 45px;" src="{$facebookLogo}" alt="Facebook" title="Facebook">
                        </a>
                    </td>
                    <td colspan="1" style="padding:20px;">
                        <a title="Instagram" href="{$instagramProfile}" target="_blank">
                            <img id="imgInstagram" class="img" style="display: block; margin: auto; height: 45px; width: 45px;" src="{$instagramLogo}" alt="Instagram" title="Instagram">
                        </a>
                    </td>
                    <td colspan="1" style="padding:20px;">
                        <a title="Youtube" href="{$youtubeChannel}" target="_blank">
                            <img id="imgYoutube" class="img" style="display: block; margin: auto; height: 45px; width: 45px;" src="{$youtubeLogo}" alt="Youtube" title="Youtube"> 
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
    public static function mailTemplateMessages(string $lang, array $params): array{
        $home_url = Properties::homeUrl();
        $privacy_url = Properties::privacyUrl($lang);
        $contacts_url = Properties::contactsUrl($lang);
        if($lang == Langs::$langs["it"]){
            return [
                0 => 'Siamo presenti anche su questi social network',
                1 => '<div>Ricevi questa comunicazione perché ti sei iscritto/a al servizio di newsletter di <a href="'.$home_url.'">La filosofia di Bianca</a> con l\'indirizzo e-mail <a href="#" style="pointer-events: none; cursor: text; text-decoration: none; color: black;"><strong>'.$params['user_email'].'</strong></a></div>',
                2 => '<div style="margin-top: 10px;">Puoi consultare <a href="'.$privacy_url.'" target="_blank" title="Privacy">qui</a> la nostra informativa sulla privacy.<br>Per ulteriori informazioni sui tuoi dati personali, contattaci a questo <a href="'.$contacts_url.'" target="_blank" title="Contattaci">link</a></div>',
                3 => 'Puoi cancellare l\'iscrizione facendo <a href="'.$params['unsubscribe_url'].'" title="Cancella iscrizione" target="_blank">click qui</a>'
            ];
        }
        else if($lang == Langs::$langs["es"]){
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