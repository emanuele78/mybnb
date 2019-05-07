<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>La tua ricevuta</title>
        <style type="text/css">
            @page {
                margin: 0;
            }

            * {
                font-family: Verdana, Arial, sans-serif;
                margin: 0;
            }

            table {
                font-size: x-small;
            }

            tfoot tr td {
                font-weight: bold;
                font-size: x-small;
            }

            .invoice table {
                margin: 15px;
            }

            .invoice h3 {
                margin-left: 15px;
            }

            .information {
                background-color: #1d2124;
                color: #FFF;
            }

            .information table {
                padding: 10px;
            }
        </style>

    </head>
    <body>

        <div class="information">
            <table width="100%">
                <tr>
                    <td align="left" style="width: 40%;">
                        <h3>MyBnB</h3>
                        <pre>
Una demo di Emanuele Mazzante
via Gargantua, 14
Gargantua 12345 (GA)
<br/><br/>
Data: {{$promo_date}}
Codice promozione: {{$promo_reference}}
Condizioni di pagamento: pagato con carta di credito
</pre>

                    </td>
                    <td align="right" style="width: 40%;">

                        <h3>{{$user_fullname}}</h3>
                        <pre>
                            {{$user_address}}
                            {{$user_locality}}
                            {{$user_email}}

                </pre>
                    </td>
                </tr>

            </table>
        </div>

        <br/>

        <div class="invoice">
            <h3>Dettagli dell'opzione acquistata</h3>
            <table width="100%">
                <thead>
                <tr>
                    <th align="left">Descrizione</th>
                    <th align="center">Numero giorni</th>
                    <th align="center">Prezzo giornaliero</th>
                    <th align="right">Totale</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td align="left">Promozione dell'appartamento denominato:</td>
                    <td align="center">{{$days_count}}</td>
                    <td align="center">€ {{number_format($price_per_day, 2, ',','.')}}</td>
                    <td align="right">€ {{number_format($days_count * $price_per_day, 2, ',','.')}}</td>
                </tr>
                <tr>
                    <td>{{$apartment_title}}</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Tipo di promozione acquistata: {{$promo_type}}</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Inzio: {{$promo_start}}</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Inzio: {{$promo_end}}</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                </tbody>
                <tfoot>
                <tr>
                    <td></td>
                    <td></td>
                    <td align="center">Totale</td>
                    <td align="right" class="gray">€ {{number_format($days_count * $price_per_day, 2, ',','.')}}</td>
                </tr>
                </tfoot>
            </table>
        </div>

        <div class="information" style="position: absolute; bottom: 0;">
            <table width="100%">
                <tr>
                    <td align="left" style="width: 50%;">
                        &copy; {{ date('Y') }} https://emanuelemazzante.dev
                    </td>
                    <td align="right" style="width: 50%;">
                        MyBnB - Una demo di Emanuele Mazzante
                    </td>
                </tr>
            </table>
        </div>
    </body>
</html>