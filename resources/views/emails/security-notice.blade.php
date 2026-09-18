<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="color-scheme" content="light">
<meta name="supported-color-schemes" content="light">
<title>{{ $heading }}</title>
<!--[if mso]>
<noscript>
<xml>
<o:OfficeDocumentSettings>
<o:PixelsPerInch>96</o:PixelsPerInch>
</o:OfficeDocumentSettings>
</xml>
</noscript>
<![endif]-->
<style>
  body, table, td { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; }
  @media only screen and (max-width: 600px) {
    .container { width: 100% !important; }
    .content-cell { padding: 28px 22px !important; }
  }
</style>
</head>
<body style="margin:0; padding:0; background-color:#FFF8F0; -webkit-text-size-adjust:100%; -ms-text-size-adjust:100%;">
<div style="display:none; max-height:0; overflow:hidden; opacity:0; mso-hide:all;">{{ $intro }}</div>

<table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:#FFF8F0;">
<tr>
<td align="center" style="padding: 40px 16px;">

    <table role="presentation" class="container" width="560" cellpadding="0" cellspacing="0" border="0" style="width:560px; max-width:560px; background-color:#ffffff; border-radius:16px; overflow:hidden; box-shadow:0 12px 32px rgba(52,28,2,0.10);">

        {{-- Top accent bar --}}
        <tr>
            <td bgcolor="#964B00" style="background-color:#964B00; background-image:linear-gradient(90deg,#341C02,#964B00,#D4A853); height:6px; line-height:6px; font-size:0;">&nbsp;</td>
        </tr>

        {{-- Header / logo --}}
        <tr>
            <td align="center" style="padding: 36px 24px 8px;">
                <img src="{{ asset('logo-04.svg') }}" alt="{{ config('app.name') }}" width="140" style="display:block; width:140px; height:auto; border:0;">
            </td>
        </tr>

        {{-- Icon badge --}}
        <tr>
            <td align="center" style="padding: 20px 24px 0;">
                <table role="presentation" cellpadding="0" cellspacing="0" border="0">
                    <tr>
                        <td width="64" height="64" align="center" valign="middle" bgcolor="#FFF3E0" style="width:64px; height:64px; background-color:#FFF3E0; border-radius:50%;">
                            @if($icon === 'lock')
                            <!--[if !mso]><!-->
                            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#964B00" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="5" y="11" width="14" height="9" rx="2"></rect><path d="M8 11V7a4 4 0 018 0v4"></path></svg>
                            <!--<![endif]-->
                            <!--[if mso]>
                            <span style="font-size:26px; color:#964B00; font-weight:bold; line-height:64px;">&#128274;</span>
                            <![endif]-->
                            @else
                            <!--[if !mso]><!-->
                            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#964B00" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            <!--<![endif]-->
                            <!--[if mso]>
                            <span style="font-size:26px; color:#964B00; font-weight:bold; line-height:64px;">&#10003;</span>
                            <![endif]-->
                            @endif
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        {{-- Body --}}
        <tr>
            <td class="content-cell" style="padding: 20px 40px 8px;">
                <h1 style="margin:0 0 14px; font-family: Georgia, 'Times New Roman', serif; font-size:24px; line-height:1.3; font-weight:700; color:#341C02; text-align:center;">{{ $heading }}</h1>
                <p style="margin:0 0 24px; font-size:15px; line-height:1.65; color:#5b4636; text-align:center;">{{ $intro }}</p>
            </td>
        </tr>

        {{-- CTA button (bulletproof pattern) --}}
        <tr>
            <td align="center" style="padding: 0 40px 8px;">
                <table role="presentation" cellpadding="0" cellspacing="0" border="0">
                    <tr>
                        <td align="center" bgcolor="#964B00" style="border-radius:8px; background-color:#964B00;">
                            <a href="{{ $buttonUrl }}" target="_blank" style="display:inline-block; padding:14px 36px; font-size:15px; font-weight:700; color:#ffffff; text-decoration:none; border-radius:8px; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;">{{ $buttonText }}</a>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        @if($expiryNote)
        {{-- Expiry panel --}}
        <tr>
            <td style="padding: 24px 40px 0;">
                <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:#FFF3E0; border-radius:8px;">
                    <tr>
                        <td style="border-left:4px solid #964B00; padding:12px 16px; font-size:13px; line-height:1.6; color:#5b4636; border-radius:0 8px 8px 0;">{{ $expiryNote }}</td>
                    </tr>
                </table>
            </td>
        </tr>
        @endif

        {{-- Fallback link --}}
        <tr>
            <td style="padding: 24px 40px 0;">
                <p style="margin:0 0 8px; font-size:12px; color:#a08a75; text-align:center;">Or copy and paste this link into your browser:</p>
                <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:#FAF5F0; border-radius:6px;">
                    <tr>
                        <td style="padding:10px 14px; font-size:12px; color:#964B00; word-break:break-all; text-align:center;">
                            <a href="{{ $buttonUrl }}" style="color:#964B00; text-decoration:none;">{{ $buttonUrl }}</a>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        {{-- Divider + closing note --}}
        <tr>
            <td style="padding: 28px 40px 32px;">
                <div style="border-top:1px solid #f0e8e0; padding-top:20px;">
                    <p style="margin:0; font-size:13px; line-height:1.6; color:#a08a75; text-align:center;">{{ $closingNote }}</p>
                </div>
            </td>
        </tr>
    </table>

    {{-- Footer --}}
    <table role="presentation" class="container" width="560" cellpadding="0" cellspacing="0" border="0" style="width:560px; max-width:560px;">
        <tr>
            <td align="center" style="padding: 24px 20px;">
                <p style="margin:0; font-size:12px; color:#b09a86;">&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
            </td>
        </tr>
    </table>

</td>
</tr>
</table>
</body>
</html>
