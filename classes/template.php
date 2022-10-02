<?php

namespace Newsletter\Classes;

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
}
?>