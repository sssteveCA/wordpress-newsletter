<?php

namespace Newsletter\Classes;

use Newsletter\Enums\Langs;
use Newsletter\Classes\Properties;
use Newsletter\Traits\TemplateTrait;

class Template{

    use TemplateTrait;

    /**
     * Activation mail HTML body
     */
    public static function activationMailTemplate(string $lang, array $params): string{
        //echo "template.php activationMailTemplate params => ".var_export($params,true)."\r\n";
        $messages = Template::activationMailMessages($lang,$params);
        //echo "template.php activationMailTemplate moreInfo => ".var_export($moreInfo,true)."\r\n";
        $htmlTemplate = <<<HTML
<!DOCTYPE html>
<html lang="it">
    <head>
        <title>{$messages['title']}</title>
        <meta charset="utf-8">
    </head>
    <body>
    <p>{$messages['link']}</p>
    <p>{$messages['codeWithLink']}</p>
    <p>{$messages['moreInfo']}</p>
    </body>
</html>
HTML;
        return $htmlTemplate;
    }

    /**
     * Mail sent when a user is added by admin
     */
    public static function addUserAdminTemplate(string $lang, array $params): string{
        $messages = Template::addUserAdminMessages($lang,$params);
        return <<<HTML
<!DOCTYPE html>
<html lang="it">
    <head>
        <title>{$messages['title']}</title>
        <meta charset="utf-8">
    </head>
    <body>
        <div style="padding: 40px 20px; text-align: center;">
        <p>{$messages['added']}</p>
        <p>{$messages['receive']}</p>
        <p>{$messages['moreInfo']}</p>
        <p>{$messages['moreInfoMail']}</p>
        </div>
    </body>
</html>
HTML;
    }

    /**
     * Mail sent to the user when is removed from the administrator
     */
    public static function deleteUserTemplate(string $lang, array $params): string{
        $messages = Template::deleteUserMessages($lang,$params);
        return <<<HTML
        <!DOCTYPE html>
        <html lang="it">
            <head>
                <title>Cancellazione utente</title>
                <meta charset="utf-8">
            </head>
            <body>
                <div style="padding: 40px 20px; text-align: center;">
                <p>{$messages['removed']}</p>
                <p>{$messages['moreInfo']}</p>
                <p>{$messages['moreInfoMail']}</p>
                </div>
            </body>
        </html>
HTML;
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
     * Mail sent to the admin when a new user has subscribed to the newsletter
     */
    public static function newSubscriberTemplate(string $email): string{
        return <<<HTML
<!DOCTYPE html>
<html lang="it">
    <head>
        <title>Nuovo iscritto alla newsletter</title>
        <meta charset="utf-8">
    </head>
    <body>
        <div style="padding: 40px 20px; text-align: center;">Un utente con email {$email} si è iscritto alla newsletter</div>
    </body>
</html>
HTML;
    }

    /**
     * Mail sent when an user unsubscribes from the newsletter
     */
    public static function unsubscribedUserTemplate(string $email): string{
        return <<<HTML
<!DOCTYPE html>
<html lang="it">
    <head>
        <title>Cancellazione utente</title>
        <meta charset="utf-8">
    </head>
    <body>
        <div style="padding: 40px 20px; text-align: center;">L'utente con email {$email} si è cancellato dalla newsletter</div>
    </body>
</html>
HTML;
    }
}
?>