<?php
function template_header_en() {
    echo '
    <table width="100%" cellpadding="0" cellspacing="0" style="font-family: Arial; background-color: rgb(247, 247, 247); margin: 0;">
        <tr>
            <td style="background-color: #333f50; padding: 10px; margin-bottom: 20px;">
                <table width="100%" cellpadding="0" cellspacing="0">
                    <tr>
                        <td align="center">
                            <a href="http://www.techneart.ipt.pt/" style="display: inline-block;">
                                <img src="http://www.techneart.ipt.pt/tecnart/assets/images/TechnArt5FundoTrans.png" alt="Logo" width="270" style="display: block;" />
                            </a>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    ';
}

function template_noticias_en($titulo, $noticias) {
    $noticias_json = json_decode($noticias, true);
    echo '
    <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom: 30px;">
        <tr>
            <td style="background-color: white; border-radius: 10px; padding: 20px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
                <h1 style="text-align: center; margin: 0;">'. $titulo .'</h1>
            </td>
        </tr>
    </table>
    ';

    foreach ($noticias_json as $noticia) {
        echo '
        <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom: 30px;">
            <tr>
                <td style="background-color: white; border-radius: 10px; padding: 20px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
                    <table width="100%" cellpadding="0" cellspacing="0">
                        <tr>
                            <td align="center" style="padding-bottom: 10px;">
                                <a href="http://www.techneart.ipt.pt/tecnart/noticia.php?noticia='. $noticia['id'] .'" style="display: inline-block;">
                                    <img src="http://www.techneart.ipt.pt/backoffice/assets/noticias/'. $noticia['imagem'] .'" alt="Imagem da Notícia" width="270" style="max-width: 100%; height: auto; border-radius: 10px; display: block;" />
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td align="center" style="padding-top: 10px;">
                                <div style="font-size: 18px; font-weight: bold; margin-bottom: 5px;">'. $noticia['tituloEn'] .'</div>
                                <div style="font-size: 14px; color: #888;">'. $noticia['data'] .'</div>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        ';
    }
}

function template_footer_en($token) {
    echo '
        <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #333f50; margin-top: 20px;">
            <tr>
                <td align="center" style="padding: 10px;">
                    <a href="#" style="color: white; text-decoration: none; margin-right: 20px; font-weight: bold;">Cancel Subscription</a>
                </td>
            </tr>
        </table>
    </div>
    ';
}
?>