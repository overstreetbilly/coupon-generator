<?php
if ( ! defined( 'ABSPATH' )){
    exit;
}
function wpdocs_set_html_mail_content_type() {
    return 'text/html';
}
add_filter( 'wp_mail_content_type', 'wpdocs_set_html_mail_content_type' );
function da_send_coupon_email(){
                global $email;
                global $coupon_code;
                $to = $email;
                $subject = "Free Sample code";

                $message = "
                <html>
                   <head>
                       <style>
                            body {font-family: monospace;} hr {
                            border: 0;
                            border-bottom: 1px dashed #ccc;
                            background: #bbb;
                            }
                        </style>
                    </head>
                    <body>
    
                    <title>Trulers</title>
                    <div id='wrapper' dir='ltr' style='background-color: #f7f7f7;margin: 0;padding: 70px 0 70px 0;width: 100%'>
                        <table border='0' cellpadding='0' cellspacing='0' width='100%'>
                            <tbody>
                                <tr>
                                    <td align='center' valign='top'>
                                        <div id='template_header_image'>
                                                <p style='margin-top: 0'>
                                                    <img src='https://www.trulers.com/wp-content/uploads/2018/08/Trulers-Logo-Transparent-Background-500.png' alt='Trulers' style='border: none;font-size: 14px;font-weight: bold;height: auto;text-decoration: none;vertical-align: middle;margin-right: 10px'>
                                                </p>
                                       </div>
                    <table border='0' cellpadding='0' cellspacing='0' width='600' id='template_container'>
                    <tbody>
                        <tr>
                        <td align='center' valign='top'>
                        <!-- Header -->
                    <table border='0' cellpadding='0' cellspacing='0' width='600' id='template_header' style='background-color: #f1272b;color: #ffffff;border-bottom: 0;font-weight: bold;line-height: 100%;vertical-align: middle;font-family: &quot;Helvetica Neue&quot;, Helvetica, Roboto, Arial, sans-serif'><tbody><tr>
                        <td id='header_wrapper' style='padding: 36px 48px'>
                        <h1 style='color: #ffffff;font-family: &quot;Helvetica Neue&quot;, Helvetica, Roboto, Arial, sans-serif;font-size: 30px;font-weight: 300;line-height: 150%;margin: 0;text-align: left'>Here is your coupon code: $coupon_code</h1>
                        </td>
                        </tr>
                        </tbody>
                        </table>
                        <!-- End Header -->
                        </td>
                        </tr>
                        <tr>
                        <td align='center' valign='top'>
                        <!-- Body -->
                    <table border='0' cellpadding='0' cellspacing='0' width='600' id='template_body'>
                    <tbody>
                    <tr>
                    <td valign='top' id='body_content' style='background-color: #ffffff'>
                    <!-- Content -->
                    <table border='0' cellpadding='20' cellspacing='0' width='100%'>
                    <tbody>
                    <tr>
                    <td valign='top' style='padding: 48px 48px 0'>
                    <div id='body_content_inner' style='color: #636363;font-family: &quot;Helvetica Neue&quot;, Helvetica, Roboto, Arial, sans-serif;font-size: 14px;line-height: 150%;text-align: left'>

                    <p style='margin: 0 0 16px'>Congragulations! Your coupon code is now active. Use this <a href='https://www.trulers.com/cart/?add-to-cart=136'>link</a> to order the sample. If the link does not work, copy and paste this url:https://www.trulers.com/shop/?add-to-cart=136 into your browser.</p>
                        <p style='margin: 0 0 16px'>Add the code at checkout for free sample and free shipping.</p>
                    <p style='margin: 0 0 16px'>This coupon is not valid with any other offer and can be used only once.</p>
                    <p style='margin: 0 0 16px'>To unsubscribe from future marketing emails, click here.</p>

                    <div style='margin-bottom: 40px'><table class='td' cellspacing='0' cellpadding='6' style='width: 100%;font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif;color: #636363;border: 1px solid #e5e5e5;vertical-align: middle' border='1'>

                    </table>
                    </div>			
                    </div>
                        </td>
                        </tr>
                        </tbody>
                        </table>
                    <!-- End Content -->
                    </td>

                    </tr>
                    </tbody>
                    </table>
                    <!-- End Body -->
                    </td>
                                                </tr>
                    <tr>
                    <td align='center' valign='top'>
                                                        <!-- Footer -->
                    <table border='0' cellpadding='10' cellspacing='0' width='600' id='template_footer'><tbody><tr>
                    <td valign='top' style='padding: 0'>
                    <table border='0' cellpadding='10' cellspacing='0' width='100%'><tbody><tr>
                    <td colspan='2' valign='middle' id='credit' style='padding: 0 48px 48px 48px;border: 0;color: #f77d80;font-family: Arial;font-size: 12px;line-height: 125%;text-align: center'>
                    <p>Trulers.com – Trulers Save Time!</p>
                    </td>								</tr></tbody></table>
                    </td></tr></tbody></table>
                    <!-- End Footer -->
                    </td>						</tr>
                    </tbody>
                    </table>
                        </td>
                        </tr>
                        </tbody>
                        </table>
                        </div>
                        </body>
                    </html>";

                // Always set content-type when sending HTML email
                $headers = "MIME-Version: 1.0" . "\r\n";
                $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                // More headers
                $headers .= 'From: <automated@trulers.com>' . "\r\n";
                
                wp_mail($to,$subject,$message,$headers);
}
// Reset content-type to avoid conflicts -- https://core.trac.wordpress.org/ticket/23578
remove_filter( 'wp_mail_content_type', 'wpdocs_set_html_mail_content_type' );