<!DOCTYPE html>
<html lang="mg">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        .header, .footer { text-align: center; margin-bottom: 10px; }
        .section { margin-top: 15px; }
        .bold { font-weight: bold; }
        .underline { text-decoration: underline; }
        .box { border: 1px solid #000; padding: 10px; margin-top: 10px; }
    </style>
</head>
<body>

<div class="header">
    <div class="bold">MINISTERAN'NY FITSINJARAM-PAHEFANA SY NY FANAJARIANA NY TANY</div>
    <div>SEKRETERA JENERALY</div>
    <div>FITALEAVANA ANKAPOBENY - FAHEFANA MIARO NY LEMAK' ANTANANARIVO AMIN'NY TONDRA-DRANO</div>
    <div class="bold">REPOBLIKAN'I MADAGASIKARA - Fitiavana · Tanindrazana · Fandrosoana</div>
    <div class="bold">AUTORITE POUR LA PROTECTION CONTRE LES INONDATIONS DE LA PLAINE D'ANTANANARIVO (APIPA)</div>
</div>

<div class="section">
    <div class="bold underline">FT laharana faha: {{ $ft->num_ft }}</div>
    <div class="bold">FITANANA AN-TSORATRA</div>
</div>

<div class="section">
    <p><strong>Antony :</strong> {{ $ft->antony_ft }}</p>
    <p><strong>Daty :</strong> {{ $ft->date }}</p>
    <p><strong>Toerana :</strong> Biraon'ny APIPA {{ $ft->comm_desc }}</p>
    <p><strong>Tanjona :</strong> Fampanarahan-dalàna</p>
</div>

<div class="section box">
    <p><strong>Toerany :</strong> {{ $ft->fkt_desc }} {{ $ft->comm_desc }}</p>
    <p><strong>Titra laharana :</strong> {{ $ft->pu }}</p>
    <p><strong>X=</strong> {{ $ft->x_desc }}, <strong>Y=</strong> {{ $ft->y_desc }}</p>
    <p><strong>Anarany :</strong> {{ $ft->nom_pers_venue }}</p>
    <p><strong>Velaran-tany :</strong> {{ $ft->objet_ft }}</p>
</div>

<div class="section">
    <p><strong>Antontan-taratasy :</strong></p>
    <ul>
        @foreach ($ft->pieces_apporter ?? [] as $piece)
            <li>{{ $piece }}</li>
        @endforeach
    </ul>
</div>

<div class="section">
    <p><strong>Fepetra nampitain'ny APIPA :</strong></p>
    <ul>
        <li>Atsahatra sy ato ny asa rehetra mandra-pahazoana alalana</li>
        <li>Mandoa sazy araka ny didim-panjakana 2019-1543</li>
        <li>Manome toky fa tsy hanetsika akora</li>
        <li>Manao taratasy fangatahana lakandrano</li>
        <li>Maka mpandrefy tany matihanina</li>
        <li>Mitondra fanampin'antontan-taratasy (sarin-tany, drafi-panajariana)</li>
    </ul>
    <p><strong>Fe-potoana :</strong> {{ $ft->delais }} andro</p>
</div>

<div class="section">
    <p><strong>Fanamarihana :</strong> {{ $ft->recommandation }}</p>
</div>

<div class="footer">
    <p>Lot IV W 18 E Anosizato - Est, Antananarivo IV</p>
    <p>Email: apipatana.dg@yahoo.com | Tel: +261 34 44 273 32</p>
</div>

</body>
</html>
