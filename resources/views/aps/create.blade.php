<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Avis de Paiement</title>
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
            font-size: 12px;
            line-height: 1.4;
            color: #000;
            background-color: #fff;
        }
        
        .page {
            width: 210mm;
            height: 297mm;
            margin: 0 auto;
            position: relative;
            box-sizing: border-box;
            page-break-after: always;
            /* padding: 15mm; */
        }
        
        /* Première page */
      .page-1 header {
    height: 200px;
    width: 100%;
    background-image: url(./header_vm.png);
    background-size: cover;
    background-repeat: no-repeat;
    /* background-position: ce; */
    margin-bottom: 20px;
}
        
        /* Deuxième page */
        .page-2 {
            padding-top: 33mm;
            
        }
        .head{
            height: 50px;
      
               height: 200px;
    width: 100%;
    background-image: url(./header_vm.png);
    background-size: cover;
    background-repeat: no-repeat;
    /* background-position: ce; */
    margin-bottom: 20px;
        }
        
 
        
        /* Styles communs */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 5mm;
        }
        
        td {
            vertical-align: top;
            padding: 2px;
        }
        
        .info-table {
            border: 1px solid black;
            margin: 5mm 0;
        }
        
        .info-table td, .info-table th {
            border: 1px solid black;
            padding: 3px;
            text-align: center;
        }
        
        .text-center {
            text-align: center;
        }
        
        .text-right {
            text-align: right;
        }
        
        .text-left {
            text-align: left;
        }
        
        .signature-section {
            margin-top: 15mm;
        }
        
        .document-title {
            font-size: 14px;
            font-weight: bold;
            margin: 8mm 0;
            text-decoration: underline;
        }
        
        .content-block1 {
            margin-bottom: 4mm;
            padding: 50px;
            /* background-color: #4CAF50; */
        }
        .content-block2{
            /* margin-bottom: 4mm; */
            padding:50px;
            position: relative;
            bottom: 200px;
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
        
        .page-number {
            position: absolute;
            bottom: 10mm;
            right: 15mm;
            font-size: 10px;
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
                padding: 15mm;
                page-break-after: always;
            }
            
            .no-print {
                display: none;
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
    height: 100px;
    width: 90%; /* Ajout d'une largeur fixe */
    position: relative;
    top: -160px;
    background-image: url(./assets/img/emblème_vf.png);
    background-size: contain;
    background-repeat: no-repeat;
    background-position: center center;
    margin: 0 auto; /* Centrer horizontalement */
}
    .document-content{
        position: relative;
        bottom: 130px;
    }
    .signature-section{
       
        /* width: 100px; */
        /* background-color: #4CAF50; */
        /* padding: 100px; */
        width: 95%;
        position: relative;
        bottom: 70px;
        
    }
.foot {
    height: 250px;
    background-image: url(./assets/img/footer.png);
    background-size: cover;
    background-repeat: no-repeat;
    background-position: center center;
    background-color: transparent;
    
    position: relative;
    bottom: 135px;
}
.page-number2{
    /* background-color: bisque; */
    height: 250px;
    background-image: url(./assets/img/footer.png);
    background-size: cover;
    background-repeat: no-repeat;
    background-position: center center;
    background-color: transparent;
    position: relative;
    bottom: 250px;
}

    </style>
</head>
<body>
    <!-- Première page -->
    <div class="page page-1">
        <header></header>
        <div class="troislogo">
            
        </div>
        <div class="document-content">
            <table>
                <tr>
                    <td style="width: 45%; vertical-align: top; text-align: center;">
                        <strong>Ministeran'ny Fitsinjiram-pahefana<br>sy ny Fanajariana ny Tany<br>
                        --------------------<br>
                        Sekretera Jeneraly<br>
                        --------------------<br>
                        <em>Fitaleavana Ankapobeny</em><br>
                        <em>Fahefana misahana ny fiarovana ny</em><br>
                        <em>Lemak'Antananarivo amin'ny tondra-drano</em><br>
                        --------------------</strong>
                    </td>
                    <td style="width: 10%;"></td>
                    <td style="width: 45%; vertical-align: top; text-align: center;">
                        Antananarivo, le .................<br><br>
                        Le Directeur Général<br><br>
                        À<br><br>
                        <strong>{{ $proprietes->proprietaire }}</strong>
                    </td>
                </tr>
            </table>

            <div class="document-title text-center">
                Avis de Paiement n°<u>039</u>/2025
            </div>
            
            <div class="content-block1">
                <p>En application des dispositions du <em>décret n°2019-1543 du 11 septembre 2019 portant régulation de l'exécution des travaux de remblaiement dans les zones d'intervention de l'APIPA, en application de la loi n°2015-052 du 03 février 2016 relative à l'Urbanisme et à l'Habitat</em> ;</p>
                
                <p>Vu le rapport de descente n°015/25 en date du 21/02/2025 effectué par l'équipe composée des Polices de l'Aménagement du Territoire/Brigade Spéciale ;</p>
                
                <p>Vu le certificat de situation juridique de la propriété dite {{ $proprietes->imm }} sise à {{ $proprietes->comm_desc }} en date du 08/10/2024 ;</p>
                
                <p>Vu le plan officiel ;</p>
                
                <p>Par la présente,</p>
                
                <p>Nous vous informons que le montant de <strong>{{ $taux_lettre }}</strong> (<strong>{{ number_format($taux, 0, '', ' ') }} Ar</strong>), dont les détails se trouvent au verso de ce document, est dû à l'Autorité pour la Protection contre les Inondations de la Plaine d'Antananarivo (APIPA) à titre <u>d'<strong>amande</strong></u> relative aux travaux de remblai et/ou de déblai illicites effectués sur votre propriété correspondant aux coordonnées « X = 519888 et Y = 796060»</p>
                
                <p>Vous êtes contraint de procéder au règlement de ce montant dans les quinzaines (15 jours) à compter de la réception de la présente par le moyen <em>d'un chèque de banque dûment légalisé par l'établissement bancaire auquel vous êtes affilié, et adressé à l'ordre de « Monsieur l'Agent Comptable de l'Autorité pour la Protection contre les Inondations de la Plaine d'Antananarivo (APIPA) ».</em></p>
            </div>

            <table class="signature-section">
                <tr>
                    <td style="width: 60%;"></td>
                    <td style="width: 40%; text-align: right;">
                        <em>Le Directeur Général,</em><br><br><br>
                        <strong>_________________________</strong>
                    </td>
                </tr>
            </table>
            <div class="foot"></div>
            
        </div>

    </div>
    
    <!-- Deuxième page -->
    <div class="page page-2">
        <div class="document-content">
            <div class="head"></div>

            <div class="content-block2">

                <p><strong><u>INFORMATIONS FONCIERES</u> :</strong></p>
                
                <p><strong><u>Titre N°:</u></strong> {{ $proprietes->titre }}</p>
                
                <p><strong><u>Coordonnées :</u></strong></p>
                <p>X = {{ $fts->x_desc }}</p>
                <p>Y = {{ $fts->y_desc }}</p>
                
                <p><strong><u>Localisation :</u></strong> {{ $descente->fkt }}</p>
            </div>
            
            <div class="content-block" style="padding: 50px;position: relative;bottom: 300px;">
                <p><strong><u>TABLEAU PORTANT REFERENCE DE CALCUL</u> :</strong></p>
                
                <table class="info-table">
                    <tr>
                        <th style="width: 20%;">N° Titre</th>
                        <th style="width: 20%;">Destination</th>
                        <th style="width: 20%;">Superficie</th>
                        <th style="width: 20%;">Valeur de l'amande/redevance par unité</th>
                        <th style="width: 20%;">Montant</th>
                    </tr>
                    <tr>
                        <td>{{ $proprietes->titre }}</td>
                        <td>{{ $proprietes->destination }}</td>
                        <td>{{ $proprietes->superficie }} m²</td>
                        <td>{{$base}}</td>
                        <td>{{ number_format($taux, 0, '', ' ') }} Ar</td>
                    </tr>
                </table>
                
                <p>Le montant total à payer s'élève à {{ $taux_lettre }}.</p>
            </div>
            
            <table class="signature-section" style="position: relative;bottom: 380px;">
                <tr>
                    <td style="width: 50%;"></td>
                    <td style="width: 50%; text-align: right;">
                        Antananarivo, le .................<br><br>
                        <em>Le Directeur Général,</em><br><br><br>
                        <strong>_________________________</strong>
                    </td>
                </tr>
            </table>
            
            <!-- <footer></footer> -->
        </div>
            <div class="page-number2"></div>

    </div>
    

</body>
</html>