<!DOCTYPE html>
<html lang="ru" xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="color-scheme" content="light only" />
<meta name="supported-color-schemes" content="light only" />
<title>{{ config('app.name') }} — Договор подписан</title>
<!--[if mso]>
<noscript><xml><o:OfficeDocumentSettings><o:PixelsPerInch>96</o:PixelsPerInch></o:OfficeDocumentSettings></xml></noscript>
<![endif]-->
<style>
  @import url('https://fonts.googleapis.com/css2?family=Golos+Text:wght@400;500;600;700&display=swap');
  html, body { margin: 0 !important; padding: 0 !important; width: 100% !important; }
  * { -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; }
  table, td { mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-collapse: collapse; }
  img { -ms-interpolation-mode: bicubic; border: 0; outline: none; text-decoration: none; display: block; }
  a { text-decoration: none; }
  body { background-color: #ECE7E1; }
  .email-wrap { width: 100%; background-color: #ECE7E1; }
  @media only screen and (max-width: 620px) {
    .container { width: 100% !important; }
    .px { padding-left: 24px !important; padding-right: 24px !important; }
    .stack { display: block !important; width: 100% !important; }
    .stack-r { display: block !important; width: 100% !important; padding-left: 0 !important; padding-top: 28px !important; }
    .hide-sm { display: none !important; }
    .adv-cell { display: block !important; width: 100% !important; padding-right: 0 !important; }
  }
</style>
</head>
<body style="margin:0; padding:0; background-color:#ECE7E1;">
<div style="display:none; max-height:0; overflow:hidden; mso-hide:all; font-size:1px; line-height:1px; color:#ECE7E1; opacity:0;">
  Ваш договор подписан онлайн. Реквизиты и подтверждение электронной подписи — внутри письма.
</div>

<table role="presentation" class="email-wrap" width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:#ECE7E1;">
  <tr>
    <td align="center" style="padding:32px 12px;">

      <!-- ============ CONTAINER ============ -->
      <table role="presentation" class="container" width="600" cellpadding="0" cellspacing="0" border="0" style="width:600px; max-width:600px; background-color:#FFFFFF; border:1px solid #E7E1DC; border-radius:14px; overflow:hidden;">

        <!-- top accent bar -->
        <tr><td style="height:5px; line-height:5px; font-size:5px; background-color:#EF533F;">&nbsp;</td></tr>

        <!-- ============ HEADER ============ -->
        <tr>
          <td class="px" style="padding:30px 40px 22px 40px;">
            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0">
              <tr>
                <td valign="middle" style="vertical-align:middle;">
                  @if(!empty($contract['organization_logo']))
                    @php [$lw, $lh] = $contract['organization_logo_size']; @endphp
                    <img src="{{ $contract['organization_logo'] }}"
                         width="{{ $lw }}" height="{{ $lh }}"
                         alt="{{ $contract['organization_label'] ?? config('app.name') }}"
                         style="display:block; max-width:100%; height:auto; width:{{ $lw }}px;" />
                  @else
                    <img src="{{ asset('storage/images/email/logo.svg') }}"
                         width="300" alt="{{ config('app.name') }}"
                         style="display:block; width:300px; max-width:100%; height:auto;" />
                  @endif
                </td>
              </tr>
            </table>
          </td>
        </tr>
        <tr><td class="px" style="padding:0 40px;"><table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="height:2px; line-height:2px; font-size:2px; background-color:#EF533F;">&nbsp;</td></tr></table></td></tr>

        <!-- ============ NOTIFICATION TEXT ============ -->
        <tr>
          <td class="px" style="padding:30px 40px 4px 40px;">
            <p style="margin:0; font-family:'Golos Text', Arial, Helvetica, sans-serif; font-size:16px; line-height:26px; color:#3A3733;">
              Извещаем&nbsp;Вас, что Вами был подписан договор. Просим&nbsp;Вас выполнить надлежащим образом условия договора с Вашей стороны.
            </p>
            <p style="margin:14px 0 0 0; font-family:'Golos Text', Arial, Helvetica, sans-serif; font-size:16px; line-height:26px; color:#3A3733;">
              Благодарим&nbsp;Вас за доверие, оказанное
              @if(!empty($contract['organization_label']))
                <strong style="color:#2A2826; font-weight:700;">«{{ $contract['organization_label'] }}»</strong>.
              @else
                <strong style="color:#2A2826; font-weight:700;">нашей организации</strong>.
              @endif
            </p>
          </td>
        </tr>

        <!-- ============ DETAILS CARD ============ -->
        <tr>
          <td class="px" style="padding:26px 40px 8px 40px;">
            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:#FAF7F4; border:1px solid #EDE6E0; border-radius:12px;">
              <tr>
                <td style="padding:22px 24px 6px 24px;">
                  <p style="margin:0 0 2px 0; font-family:'Golos Text', Arial, Helvetica, sans-serif; font-size:11px; font-weight:700; letter-spacing:0.10em; text-transform:uppercase; color:#2F7D5C;">Договор подписан On-line</p>
                  @if(!empty($contract['organization_label']))
                  <p style="margin:0; font-family:'Golos Text', Arial, Helvetica, sans-serif; font-size:19px; font-weight:700; line-height:26px; color:#2A2826;">{{ $contract['organization_label'] }}</p>
                  @endif
                </td>
              </tr>
              <tr><td style="padding:14px 24px 0 24px;"><table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="height:1px; line-height:1px; font-size:1px; background-color:#EBE3DC;">&nbsp;</td></tr></table></td></tr>

              <!-- data rows -->
              <tr>
                <td style="padding:0 24px;">
                  <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0">

                    @if(!empty($contract['contract_number']))
                    <tr>
                      <td width="42%" style="padding:14px 0; font-family:'Golos Text', Arial, Helvetica, sans-serif; font-size:14px; color:#857F79; vertical-align:top;">№ договора</td>
                      <td width="58%" style="padding:14px 0; font-family:'Golos Text', Arial, Helvetica, sans-serif; font-size:15px; font-weight:600; color:#2A2826; vertical-align:top;">{{ $contract['contract_number'] }}</td>
                    </tr>
                    <tr><td colspan="2" style="height:1px; line-height:1px; font-size:1px; background-color:#EFE9E3;">&nbsp;</td></tr>
                    @endif

                    <tr>
                      <td style="padding:14px 0; font-family:'Golos Text', Arial, Helvetica, sans-serif; font-size:14px; color:#857F79; vertical-align:top;">ФИО</td>
                      <td style="padding:14px 0; font-family:'Golos Text', Arial, Helvetica, sans-serif; font-size:15px; font-weight:600; color:#2A2826; vertical-align:top;">{{ $contract['fio'] }}</td>
                    </tr>

                    @if(!empty($contract['phone']))
                    <tr><td colspan="2" style="height:1px; line-height:1px; font-size:1px; background-color:#EFE9E3;">&nbsp;</td></tr>
                    <tr>
                      <td style="padding:14px 0; font-family:'Golos Text', Arial, Helvetica, sans-serif; font-size:14px; color:#857F79; vertical-align:top;">Номер телефона</td>
                      <td style="padding:14px 0; font-family:'Golos Text', Arial, Helvetica, sans-serif; font-size:15px; font-weight:600; color:#2A2826; vertical-align:top;">{{ $contract['phone'] }}</td>
                    </tr>
                    @endif

                    @if(!empty($contract['email']))
                    <tr><td colspan="2" style="height:1px; line-height:1px; font-size:1px; background-color:#EFE9E3;">&nbsp;</td></tr>
                    <tr>
                      <td style="padding:14px 0; font-family:'Golos Text', Arial, Helvetica, sans-serif; font-size:14px; color:#857F79; vertical-align:top;">Ваш email</td>
                      <td style="padding:14px 0; font-family:'Golos Text', Arial, Helvetica, sans-serif; font-size:15px; font-weight:600; vertical-align:top;">
                        <a href="mailto:{{ $contract['email'] }}" style="color:#EF533F; font-weight:600;">{{ $contract['email'] }}</a>
                      </td>
                    </tr>
                    @endif

                    @if(!empty($contract['training_id']))
                    <tr><td colspan="2" style="height:1px; line-height:1px; font-size:1px; background-color:#EFE9E3;">&nbsp;</td></tr>
                    <tr>
                      <td style="padding:14px 0; font-family:'Golos Text', Arial, Helvetica, sans-serif; font-size:14px; color:#857F79; vertical-align:top;">Дисциплина</td>
                      <td style="padding:14px 0; font-family:'Golos Text', Arial, Helvetica, sans-serif; font-size:15px; font-weight:600; color:#2A2826; vertical-align:top;">{{ $contract['training_id'] }}</td>
                    </tr>
                    @endif

                    @if(!empty($contract['date_from']) && !empty($contract['date_to']))
                    <tr><td colspan="2" style="height:1px; line-height:1px; font-size:1px; background-color:#EFE9E3;">&nbsp;</td></tr>
                    <tr>
                      <td style="padding:14px 0; font-family:'Golos Text', Arial, Helvetica, sans-serif; font-size:14px; color:#857F79; vertical-align:top;">Период обучения</td>
                      <td style="padding:14px 0; font-family:'Golos Text', Arial, Helvetica, sans-serif; font-size:15px; font-weight:600; color:#2A2826; vertical-align:top;">{{ $contract['date_from'] }} — {{ $contract['date_to'] }}</td>
                    </tr>
                    @endif

                    @if(!empty($contract['price']))
                    <tr><td colspan="2" style="height:1px; line-height:1px; font-size:1px; background-color:#EFE9E3;">&nbsp;</td></tr>
                    <tr>
                      <td style="padding:14px 0; font-family:'Golos Text', Arial, Helvetica, sans-serif; font-size:14px; color:#857F79; vertical-align:top;">Стоимость</td>
                      <td style="padding:14px 0; font-family:'Golos Text', Arial, Helvetica, sans-serif; font-size:15px; font-weight:600; color:#2A2826; vertical-align:top;">{{ number_format((float)$contract['price'], 0, '.', ' ') }}&nbsp;{{ $contract['currency'] }}</td>
                    </tr>
                    @endif

                    @if(!empty($contract['hours']))
                    <tr><td colspan="2" style="height:1px; line-height:1px; font-size:1px; background-color:#EFE9E3;">&nbsp;</td></tr>
                    <tr>
                      <td style="padding:14px 0; font-family:'Golos Text', Arial, Helvetica, sans-serif; font-size:14px; color:#857F79; vertical-align:top;">Количество часов</td>
                      <td style="padding:14px 0; font-family:'Golos Text', Arial, Helvetica, sans-serif; font-size:15px; font-weight:600; color:#2A2826; vertical-align:top;">{{ $contract['hours'] }} ч.</td>
                    </tr>
                    @endif

                  </table>
                </td>
              </tr>

              <!-- signature block -->
              <tr>
                <td style="padding:20px 24px 24px 24px;">
                  <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:#FEF2F0; border:1.5px solid #F6BBB1; border-radius:10px;">
                    <tr>
                      <td width="56" valign="middle" style="padding:16px 0 16px 18px; vertical-align:middle;">
                        <img src="{{ asset('storage/images/email/icons/sig-seal.png') }}" width="34" height="34" alt="" style="display:block; width:34px; height:34px;" />
                      </td>
                      <td valign="middle" style="padding:16px 18px 16px 14px; vertical-align:middle;">
                        <p style="margin:0; font-family:'Golos Text', Arial, Helvetica, sans-serif; font-size:15px; font-weight:700; line-height:21px; color:#EF533F;">Документ подписан электронной подписью</p>
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>
            </table>
          </td>
        </tr>

        <!-- signed meta -->
        @if(!empty($contract['signed_at']))
        <tr>
          <td class="px" style="padding:14px 40px 4px 40px;">
            <p style="margin:0; font-family:'Golos Text', Arial, Helvetica, sans-serif; font-size:13px; line-height:20px; color:#857F79;">
              <strong style="color:#2A2826; font-weight:700;">Подписано:</strong> {{ $contract['signed_at'] }}
              @if(!empty($contract['signed_ip']))
                &nbsp;·&nbsp; IP&nbsp;{{ $contract['signed_ip'] }}
              @endif
            </p>
          </td>
        </tr>
        @endif

        <!-- ============ ADVANTAGES ============ -->
        <tr>
          <td class="px" style="padding:34px 40px 6px 40px;">
            <p style="margin:0 0 2px 0; font-family:'Golos Text', Arial, Helvetica, sans-serif; font-size:11px; font-weight:700; letter-spacing:0.10em; text-transform:uppercase; color:#EF533F;">Почему выбирают нас</p>
            <p style="margin:0 0 18px 0; font-family:'Golos Text', Arial, Helvetica, sans-serif; font-size:20px; font-weight:700; color:#2A2826;">Преимущества обучения</p>
          </td>
        </tr>
        <tr>
          <td class="px" style="padding:0 40px 6px 40px;">
            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0">
              <!-- row 1 -->
              <tr>
                <td class="adv-cell" width="50%" valign="top" style="padding:0 14px 22px 0; vertical-align:top;">
                  <table role="presentation" cellpadding="0" cellspacing="0" border="0"><tr>
                    <td width="40" valign="top" style="vertical-align:top;"><img src="{{ asset('storage/images/email/icons/adv-control.png') }}" width="26" height="26" alt="" style="display:block; width:26px; height:26px;" /></td>
                    <td valign="middle" style="vertical-align:middle; font-family:'Golos Text', Arial, Helvetica, sans-serif; font-size:14px; line-height:20px; color:#3A3733;">Персональный контроль знаний</td>
                  </tr></table>
                </td>
                <td class="adv-cell" width="50%" valign="top" style="padding:0 0 22px 14px; vertical-align:top;">
                  <table role="presentation" cellpadding="0" cellspacing="0" border="0"><tr>
                    <td width="40" valign="top" style="vertical-align:top;"><img src="{{ asset('storage/images/email/icons/adv-courses.png') }}" width="26" height="26" alt="" style="display:block; width:26px; height:26px;" /></td>
                    <td valign="middle" style="vertical-align:middle; font-family:'Golos Text', Arial, Helvetica, sans-serif; font-size:14px; line-height:20px; color:#3A3733;">Оперативная организация курсов</td>
                  </tr></table>
                </td>
              </tr>
              <!-- row 2 -->
              <tr>
                <td class="adv-cell" valign="top" style="padding:0 14px 22px 0; vertical-align:top;">
                  <table role="presentation" cellpadding="0" cellspacing="0" border="0"><tr>
                    <td width="40" valign="top" style="vertical-align:top;"><img src="{{ asset('storage/images/email/icons/adv-network.png') }}" width="26" height="26" alt="" style="display:block; width:26px; height:26px;" /></td>
                    <td valign="middle" style="vertical-align:middle; font-family:'Golos Text', Arial, Helvetica, sans-serif; font-size:14px; line-height:20px; color:#3A3733;">Взаимосвязь со всеми слушателями</td>
                  </tr></table>
                </td>
                <td class="adv-cell" valign="top" style="padding:0 0 22px 14px; vertical-align:top;">
                  <table role="presentation" cellpadding="0" cellspacing="0" border="0"><tr>
                    <td width="40" valign="top" style="vertical-align:top;"><img src="{{ asset('storage/images/email/icons/adv-best.png') }}" width="26" height="26" alt="" style="display:block; width:26px; height:26px;" /></td>
                    <td valign="middle" style="vertical-align:middle; font-family:'Golos Text', Arial, Helvetica, sans-serif; font-size:14px; line-height:20px; color:#3A3733;">Только самые лучшие условия</td>
                  </tr></table>
                </td>
              </tr>
              <!-- row 3 -->
              <tr>
                <td class="adv-cell" valign="top" style="padding:0 14px 22px 0; vertical-align:top;">
                  <table role="presentation" cellpadding="0" cellspacing="0" border="0"><tr>
                    <td width="40" valign="top" style="vertical-align:top;"><img src="{{ asset('storage/images/email/icons/adv-job.png') }}" width="26" height="26" alt="" style="display:block; width:26px; height:26px;" /></td>
                    <td valign="middle" style="vertical-align:middle; font-family:'Golos Text', Arial, Helvetica, sans-serif; font-size:14px; line-height:20px; color:#3A3733;">Помощь при трудоустройстве</td>
                  </tr></table>
                </td>
                <td class="adv-cell" valign="top" style="padding:0 0 22px 14px; vertical-align:top;">
                  <table role="presentation" cellpadding="0" cellspacing="0" border="0"><tr>
                    <td width="40" valign="top" style="vertical-align:top;"><img src="{{ asset('storage/images/email/icons/adv-nego.png') }}" width="26" height="26" alt="" style="display:block; width:26px; height:26px;" /></td>
                    <td valign="middle" style="vertical-align:middle; font-family:'Golos Text', Arial, Helvetica, sans-serif; font-size:14px; line-height:20px; color:#3A3733;">Проведём переговоры с руководством</td>
                  </tr></table>
                </td>
              </tr>
              <!-- row 4 -->
              <tr>
                <td class="adv-cell" valign="top" style="padding:0 14px 4px 0; vertical-align:top;">
                  <table role="presentation" cellpadding="0" cellspacing="0" border="0"><tr>
                    <td width="40" valign="top" style="vertical-align:top;"><img src="{{ asset('storage/images/email/icons/adv-cost.png') }}" width="26" height="26" alt="" style="display:block; width:26px; height:26px;" /></td>
                    <td valign="middle" style="vertical-align:middle; font-family:'Golos Text', Arial, Helvetica, sans-serif; font-size:14px; line-height:20px; color:#3A3733;">Снизим затраты на обучение</td>
                  </tr></table>
                </td>
                <td class="adv-cell" valign="top" style="padding:0 0 4px 14px; vertical-align:top;">
                  <table role="presentation" cellpadding="0" cellspacing="0" border="0"><tr>
                    <td width="40" valign="top" style="vertical-align:top;"><img src="{{ asset('storage/images/email/icons/adv-legal.png') }}" width="26" height="26" alt="" style="display:block; width:26px; height:26px;" /></td>
                    <td valign="middle" style="vertical-align:middle; font-family:'Golos Text', Arial, Helvetica, sans-serif; font-size:14px; line-height:20px; color:#3A3733;">Окажем правовую консультацию</td>
                  </tr></table>
                </td>
              </tr>
            </table>
          </td>
        </tr>

        <!-- ============ VALUES STRIP ============ -->
        <tr>
          <td class="px" style="padding:30px 40px 0 40px;">
            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="height:1px; line-height:1px; font-size:1px; background-color:#EBE3DC;">&nbsp;</td></tr></table>
          </td>
        </tr>
        <tr>
          <td class="px" style="padding:26px 40px 0 40px;">
            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:#FAF7F4; border:1px solid #EDE6E0; border-radius:12px;">
              <tr>
                <td width="33%" align="center" style="padding:22px 10px 20px 10px;">
                  <img src="{{ asset('storage/images/email/icons/bdn-fast.png') }}" width="30" height="30" alt="" style="display:block; width:30px; height:30px; margin:0 auto 9px auto;" />
                  <div style="font-family:'Golos Text', Arial, Helvetica, sans-serif; font-size:13px; font-weight:700; letter-spacing:0.05em; color:#2A2826;">БЫСТРО</div>
                </td>
                <td width="1" style="width:1px; line-height:1px; font-size:1px; background-color:#E7DFD8;">&nbsp;</td>
                <td width="33%" align="center" style="padding:22px 10px 20px 10px;">
                  <img src="{{ asset('storage/images/email/icons/bdn-afford.png') }}" width="30" height="30" alt="" style="display:block; width:30px; height:30px; margin:0 auto 9px auto;" />
                  <div style="font-family:'Golos Text', Arial, Helvetica, sans-serif; font-size:13px; font-weight:700; letter-spacing:0.05em; color:#2A2826;">ДОСТУПНО</div>
                </td>
                <td width="1" style="width:1px; line-height:1px; font-size:1px; background-color:#E7DFD8;">&nbsp;</td>
                <td width="33%" align="center" style="padding:22px 10px 20px 10px;">
                  <img src="{{ asset('storage/images/email/icons/bdn-reliable.png') }}" width="30" height="30" alt="" style="display:block; width:30px; height:30px; margin:0 auto 9px auto;" />
                  <div style="font-family:'Golos Text', Arial, Helvetica, sans-serif; font-size:13px; font-weight:700; letter-spacing:0.05em; color:#2A2826;">НАДЁЖНО</div>
                </td>
              </tr>
            </table>
          </td>
        </tr>

        <!-- ============ CONTACTS ============ -->
        <tr>
          <td class="px" style="padding:32px 40px 16px 40px;">
            <p style="margin:0 0 2px 0; font-family:'Golos Text', Arial, Helvetica, sans-serif; font-size:11px; font-weight:700; letter-spacing:0.10em; text-transform:uppercase; color:#EF533F;">Контакты</p>
            <p style="margin:0; font-family:'Golos Text', Arial, Helvetica, sans-serif; font-size:20px; font-weight:700; color:#2A2826;">Свяжитесь с нами</p>
          </td>
        </tr>
        <tr>
          <td class="px" style="padding:0 40px 32px 40px;">
            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0">
              <tr>
                <td class="adv-cell" width="50%" valign="top" style="vertical-align:top; padding:0 14px 24px 0;">
                  <table role="presentation" cellpadding="0" cellspacing="0" border="0"><tr>
                    <td width="34" valign="top" style="vertical-align:top;"><img src="{{ asset('storage/images/email/icons/c-pin.png') }}" width="20" height="20" alt="" style="display:block; width:20px; height:20px; margin-top:1px;" /></td>
                    <td valign="top" style="vertical-align:top; font-family:'Golos Text', Arial, Helvetica, sans-serif; font-size:14px; line-height:20px; color:#3A3733; padding-left:10px;">
                      <span style="display:block; font-size:11px; font-weight:600; letter-spacing:0.06em; text-transform:uppercase; color:#9C968F; margin-bottom:2px;">Адрес</span>
                      г. Алматы, пр. Сейфуллина 498, оф. 202
                    </td>
                  </tr></table>
                </td>
                <td class="adv-cell" width="50%" valign="top" style="vertical-align:top; padding:0 0 24px 14px;">
                  <table role="presentation" cellpadding="0" cellspacing="0" border="0"><tr>
                    <td width="34" valign="top" style="vertical-align:top;"><img src="{{ asset('storage/images/email/icons/c-phone.png') }}" width="20" height="20" alt="" style="display:block; width:20px; height:20px; margin-top:1px;" /></td>
                    <td valign="top" style="vertical-align:top; font-family:'Golos Text', Arial, Helvetica, sans-serif; font-size:14px; line-height:20px; color:#3A3733; padding-left:10px;">
                      <span style="display:block; font-size:11px; font-weight:600; letter-spacing:0.06em; text-transform:uppercase; color:#9C968F; margin-bottom:2px;">Телефон</span>
                      <a href="tel:+77272242121" style="color:#3A3733; font-weight:600;">8 (727) 224 21 21</a>
                    </td>
                  </tr></table>
                </td>
              </tr>
              <tr>
                <td class="adv-cell" valign="top" style="vertical-align:top; padding:0 14px 24px 0;">
                  <table role="presentation" cellpadding="0" cellspacing="0" border="0"><tr>
                    <td width="34" valign="top" style="vertical-align:top;"><img src="{{ asset('storage/images/email/icons/c-wa.png') }}" width="20" height="20" alt="" style="display:block; width:20px; height:20px; margin-top:1px;" /></td>
                    <td valign="top" style="vertical-align:top; font-family:'Golos Text', Arial, Helvetica, sans-serif; font-size:14px; line-height:20px; color:#3A3733; padding-left:10px;">
                      <span style="display:block; font-size:11px; font-weight:600; letter-spacing:0.06em; text-transform:uppercase; color:#9C968F; margin-bottom:2px;">WhatsApp</span>
                      <a href="https://wa.me/77074092211" style="color:#3A3733; font-weight:600;">8 (707) 409 22 11</a><br /><a href="https://wa.me/77074092266" style="color:#3A3733; font-weight:600;">8 (707) 409 22 66</a>
                    </td>
                  </tr></table>
                </td>
                <td class="adv-cell" valign="top" style="vertical-align:top; padding:0 0 24px 14px;">
                  <table role="presentation" cellpadding="0" cellspacing="0" border="0"><tr>
                    <td width="34" valign="top" style="vertical-align:top;"><img src="{{ asset('storage/images/email/icons/c-mail.png') }}" width="20" height="20" alt="" style="display:block; width:20px; height:20px; margin-top:1px;" /></td>
                    <td valign="top" style="vertical-align:top; font-family:'Golos Text', Arial, Helvetica, sans-serif; font-size:14px; line-height:20px; color:#3A3733; padding-left:10px;">
                      <span style="display:block; font-size:11px; font-weight:600; letter-spacing:0.06em; text-transform:uppercase; color:#9C968F; margin-bottom:2px;">Email</span>
                      <a href="mailto:info@hseipaa.kz" style="color:#EF533F; font-weight:600;">info@hseipaa.kz</a>
                    </td>
                  </tr></table>
                </td>
              </tr>
              <tr>
                <td class="adv-cell" valign="top" style="vertical-align:top; padding:0 14px 0 0;">
                  <table role="presentation" cellpadding="0" cellspacing="0" border="0"><tr>
                    <td width="34" valign="top" style="vertical-align:top;"><img src="{{ asset('storage/images/email/icons/c-web.png') }}" width="20" height="20" alt="" style="display:block; width:20px; height:20px; margin-top:1px;" /></td>
                    <td valign="top" style="vertical-align:top; font-family:'Golos Text', Arial, Helvetica, sans-serif; font-size:14px; line-height:20px; color:#3A3733; padding-left:10px;">
                      <span style="display:block; font-size:11px; font-weight:600; letter-spacing:0.06em; text-transform:uppercase; color:#9C968F; margin-bottom:2px;">Сайт</span>
                      <a href="{{ config('app.url') }}" style="color:#EF533F; font-weight:600;">{{ parse_url(config('app.url'), PHP_URL_HOST) }}</a>
                    </td>
                  </tr></table>
                </td>
                <td class="adv-cell hide-sm" valign="top" style="vertical-align:top;">&nbsp;</td>
              </tr>
            </table>
          </td>
        </tr>

        <!-- ============ FOOTER ============ -->
        <tr><td style="height:1px; line-height:1px; font-size:1px; background-color:#EBE3DC;">&nbsp;</td></tr>
        <tr>
          <td class="px" style="padding:22px 40px 26px 40px; background-color:#FAF7F4;">
            <p style="margin:0 0 4px 0; font-family:'Golos Text', Arial, Helvetica, sans-serif; font-size:13px; font-weight:700; color:#2A2826;">
              @if(!empty($contract['organization_label'])){{ $contract['organization_label'] }}@else{{ config('app.name') }}@endif
            </p>
            <p style="margin:0; font-family:'Golos Text', Arial, Helvetica, sans-serif; font-size:12px; line-height:19px; color:#9C968F;">
              г. Алматы<br />
              Это письмо отправлено автоматически в связи с подписанием договора. Отвечать на него не требуется.
            </p>
          </td>
        </tr>
        <tr><td style="height:5px; line-height:5px; font-size:5px; background-color:#EF533F;">&nbsp;</td></tr>

      </table>
      <!-- ============ /CONTAINER ============ -->

      <!-- sub-footer -->
      <table role="presentation" class="container" width="600" cellpadding="0" cellspacing="0" border="0" style="width:600px; max-width:600px;">
        <tr>
          <td align="center" style="padding:18px 24px 4px 24px; font-family:'Golos Text', Arial, Helvetica, sans-serif; font-size:11px; line-height:18px; color:#A39D96;">
            © {{ now()->year }} {{ config('app.name') }} · <a href="{{ config('app.url') }}" style="color:#A39D96; text-decoration:underline;">{{ parse_url(config('app.url'), PHP_URL_HOST) }}</a>
          </td>
        </tr>
      </table>

    </td>
  </tr>
</table>
</body>
</html>
