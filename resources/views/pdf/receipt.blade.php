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
                        <h3>{{$apartment_owner_fullname}}</h3>
                        <pre>
{{$apartment_owner_address}}
{{$apartment_owner_locality}}
{{$apartment_owner_email}}
<br/><br/>
Data: {{$booking_date}}
Codice prenotazione: {{$booking_reference}}
Condizioni di pagamento: pagato con carta di credito
</pre>

                    </td>
                    <td align="right" style="width: 40%;">

                        <h3>{{$user_booking_fullname}}</h3>
                        <pre>
                            {{$user_booking_address}}
                            {{$user_booking_locality}}
                            {{$user_booking_email}}

                </pre>
                    </td>
                </tr>

            </table>
        </div>

        <br/>

        <div class="invoice">
            <h3>Dettagli della prenotazione</h3>
            <table width="100%">
                <thead>
                <tr>
                    <th align="left">Descrizione</th>
                    <th align="center">Numero notti</th>
                    <th align="center">Prezzo a notte</th>
                    <th align="right">Totale</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td align="left">Soggiorno nell'appartamento denominato:</td>
                    <td align="center">{{$nights_count}}</td>
                    <td align="center">€ {{$apartment_price_per_night}}</td>
                    <td align="right">€ {{number_format($nights_count * $apartment_price_per_night, 2, ',','.')}}</td>
                </tr>
                <tr>
                    <td>{{$apartment_title}}</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Check-in: {{$check_in}}</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Check-out: {{$check_out}}</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                @if($has_upgrades)
                    <tr>
                        <td align="left">Servizi aggiuntivi acquistati:</td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    @foreach($upgrades as $upgrade)
                        <tr>
                            <td align="left">{{$upgrade['name']}}</td>
                            <td align="center">{{$nights_count}}</td>
                            <td align="center">€ {{$upgrade['price_per_night']}}</td>
                            <td align="right">€ {{number_format($nights_count * $upgrade['price_per_night'], 2, ',','.')}}</td>
                        </tr>
                    @endforeach
                @endif
                </tbody>
                <tfoot>
                <tr>
                    <td></td>
                    <td></td>
                    <td align="center">Totale</td>
                    <td align="right" class="gray">€ {{$total_amount}}</td>
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