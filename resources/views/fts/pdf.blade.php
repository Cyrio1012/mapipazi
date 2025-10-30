<!DOCTYPE html>
<html lang="mg">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fitanana an-tsoratra</title>
    <style>
        /* Styles pour l'impression A4 */
        @page {
            size: A4;
            margin: 0;
        }
        
        body {
            margin: 0;
            padding: 0;
            font-family: 'Times New Roman', serif;
            font-size: 11px;
            line-height: 1.3;
            color: #000;
            background-color: #fff;
        }
        
        .page {
            width: 210mm;
            height: 297mm;
            margin: 0 auto;
            position: relative;
            box-sizing: border-box;
        }
        
        /* Première page */
        .page-1 header {
            height: 200px;
            width: 100%;
            background-image: url(./header_vm.png);
            background-size: cover;
            background-repeat: no-repeat;
            margin-bottom: 5px;
        }
        
        /* Styles communs */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 3mm;
        }
        
        td {
            vertical-align: top;
            padding: 1px;
        }
        
        .text-center {
            text-align: center;
        }
        
        .text-right {
            text-align: right;
        }
        
        .signature-section {
            margin-top: 8mm;
        }
        
        .document-title {
            font-size: 13px;
            font-weight: bold;
            margin: 5mm 0;
            text-decoration: underline;
        }
        
        .content-block1 {
            margin-bottom: 3mm;
            padding: 0 5mm;
        }
        
        u {
            text-decoration: underline;
        }
        
        strong {
            font-weight: bold;
        }
        
        em {
            font-style: italic;
        }
        
        /* Styles d'impression */
        @media print {
            body {
                margin: 0;
                padding: 0;
                background: white;
            }
            
            .page {
                width: 100%;
                height: 100%;
                margin: 0;
                padding: 20mm;
            }
        }
        
        /* Styles pour l'aperçu à l'écran */
        @media screen {
            body {
                background-color: #f0f0f0;
                padding: 10px;
            }
            
            .page {
                background: white;
                box-shadow: 0 0 10px rgba(0,0,0,0.1);
                margin-bottom: 20px;
            }
        }
        
        .troislogo {
            height: 80px;
            width: 80%;
            position: relative;
            top: -120px;
            background-image: url(./emblème_vf.png);
            background-size: contain;
            background-repeat: no-repeat;
            background-position: center center;
            margin: 0 auto;
        }
        
        .document-content {
            position: relative;
            bottom: 100px;
            padding: 20px;
        }
        
        .foot {
            height: 250px;
            background-image: url(./footer.png);
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center center;
            background-color: transparent;
            position: relative;
            bottom: 10px;
        }

        .titre {
            font-family: Arial, Helvetica, sans-serif;
            margin: 3mm 0;
            padding: 0 5mm;
        }

        .titre p {
            margin: 2px 0;
        }

        .separator {
            border-top: 1px solid #000;
            margin: 3mm 0;
            width: 100%;
        }

        .numero-ft {
            font-family: Arial, Helvetica, sans-serif;
            margin: 2mm 0 3mm 5mm;
            font-weight: bold;
        }

        .box {
            border: 1px solid #000;
            padding: 8px;
            margin: 8px 0;
            font-size: 10px;
        }

        ul {
            margin: 2px 0;
            padding-left: 15px;
        }

        li {
            margin: 1px 0;
        }
    </style>
</head>
<body>
    <!-- Première page seulement -->
    <div class="page page-1">
        <header></header>
        <div class="troislogo"></div>
        
        <div class="document-content">
            <table>
                <tr>
                    <td style="width: 45%; vertical-align: top; text-align: center;">
                        <strong>MINISTERAN'NY FITSINJARAM-PAHEFANA SY NY FANAJARIANA NY TANY<br>
                        --------------------<br>
                        SEKRETERA JENERALY<br>
                        --------------------<br>
                        <em>FITALEAVANA ANKAPOBENY</em><br>
                        <em>FAHEFANA MIARO NY LEMAK' ANTANANARIVO AMIN'NY TONDRA-DRANO</em><br>
                        --------------------</strong>
                    </td>
                    <td style="width: 10%;"></td>
                    <td style="width: 45%; vertical-align: top; text-align: center;">
                        Antananarivo, le {{ \Carbon\Carbon::parse($ft->date)->format('d/m/Y') }}<br><br>
                        Le Directeur Général<br><br>
                        À<br><br>
                        <strong>{{ $ft->nom_pers_venue ?? 'NOM DU DESTINATAIRE' }}</strong>
                    </td>
                </tr>
            </table>

            <p class="numero-ft">FT laharana faha: {{ $ft->num_ft }}</p>

            <div class="document-title text-center" style="font-family: Arial, Helvetica, sans-serif;">
                FITANANA AN-TSORATRA
            </div>
            
            <div class="titre">
                <p style="font-weight: 600;">Antony: <span style="font-weight: 100;">{{ $ft->antony_ft }}</span></p>
                <p style="font-weight: 600;">Daty: <span style="font-weight: 100;">{{ \Carbon\Carbon::parse($ft->date)->format('d/m/Y') }}</span></p>
                <p style="font-weight: 600;">Toerana: <span style="font-weight: 100;">Biraon'ny APIPA {{ $ft->comm_desc }}</span></p>
                <p style="font-weight: 600;">Tanjona: <span style="font-weight: 100;">Fampanarahan-dalàna</span></p>
                <div class="separator"></div>
            </div>
            
            <div class="content-block1">
                <div class="box">
                    <p style="font-weight: 600; margin: 2px 0;">Toerany: <span style="font-weight: 100;">{{ $ft->fkt_desc }} {{ $ft->comm_desc }}</span></p>
                    <p style="font-weight: 600; margin: 2px 0;">Titra laharana: <span style="font-weight: 100;">{{ $ft->pu }}</span></p>
                    <p style="font-weight: 600; margin: 2px 0;">X = <span style="font-weight: 100;">{{ $ft->x_desc }}</span>, Y = <span style="font-weight: 100;">{{ $ft->y_desc }}</span></p>
                    <p style="font-weight: 600; margin: 2px 0;">Anarany: <span style="font-weight: 100;">{{ $ft->nom_pers_venue }}</span></p>
                    <p style="font-weight: 600; margin: 2px 0;">Velaran-tany: <span style="font-weight: 100;">{{ $ft->objet_ft }}</span></p>
                </div>

                <p style="font-weight: 600; margin: 8px 0 2px 0;">Antontan-taratasy:</p>
                <ul>
                    @foreach ($ft->pieces_apporter ?? [] as $piece)
                        <li style="font-weight: 100;">{{ $piece }}</li>
                    @endforeach
                </ul>

                <p style="font-weight: 600; margin: 8px 0 2px 0;">Fepetra nampitain'ny APIPA:</p>
                <ul>
                    <li style="font-weight: 100;">Atsahatra sy ato ny asa rehetra mandra-pahazoana alalana</li>
                    <li style="font-weight: 100;">Mandoa sazy araka ny didim-panjakana 2019-1543</li>
                    <li style="font-weight: 100;">Manome toky fa tsy hanetsika akora</li>
                    <li style="font-weight: 100;">Manao taratasy fangatahana lakandrano</li>
                    <li style="font-weight: 100;">Maka mpandrefy tany matihanina</li>
                    <li style="font-weight: 100;">Mitondra fanampin'antontan-taratasy (sarin-tany, drafi-panajariana)</li>
                </ul>
                
                <p style="font-weight: 600; margin: 8px 0 2px 0;">Fe-potoana: <span style="font-weight: 100;">{{ $ft->delais }} andro</span></p>

                <p style="font-weight: 600; margin: 8px 0 2px 0;">Fanamarihana: <span style="font-weight: 100;">{{ $ft->recommandation }}</span></p>
            </div>

            <table class="signature-section">
                <tr>
                    <td style="width: 60%;">
                        <p style="margin: 2px 0; font-weight: 100;">Lot IV W 18 E Anosizato - Est, Antananarivo IV</p>
                        <p style="margin: 2px 0; font-weight: 100;">Email: apipatana.dg@yahoo.com | Tel: +261 34 44 273 32</p>
                    </td>
                    <td style="width: 40%; text-align: right;">
                        <em>Le Directeur Général,</em><br><br><br>
                        <strong>_________________________</strong>
                    </td>
                </tr>
            </table>
        </div>
        
        <div class="foot"></div>
    </div>
</body>
</html>