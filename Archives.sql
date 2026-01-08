-- Créer une table temporaire
CREATE TEMP TABLE temp_import (
    id TEXT,
    exoyear TEXT,
    arrivaldate TEXT,
    arrivalid TEXT,
    sendersce TEXT,
    descentdate TEXT,
    reportid TEXT,
    summondate TEXT,
    actiontaken TEXT,
    measures TEXT,
    findingof TEXT,
    applicantname TEXT,
    applicantaddress TEXT,
    applicantcontact TEXT,
    locality TEXT,
    municipality TEXT,
    property0wner TEXT,
    propertytitle TEXT,
    propertyname TEXT,
    pu TEXT,
    upr TEXT,
    zoning TEXT,
    surfacearea TEXT,
    backfilledarea TEXT,
    xv TEXT,
    yv TEXT,
    minutesid TEXT,
    minutesdate TEXT,
    partsupplied TEXT,
    submissiondate TEXT,
    destination TEXT,
    svr_fine TEXT,
    svr_roalty TEXT,
    invoicingid TEXT,
    invoicingdate TEXT,
    fineamount TEXT,
    roaltyamount TEXT,
    convention TEXT,
    payementmethod TEXT,
    daftransmissiondate TEXT,
    ref_quitus TEXT,
    sit_r TEXT,
    sit_a TEXT,
    commissiondate TEXT,
    commissionopinion TEXT,
    recommandationobs TEXT,
    opfinal TEXT,
    opiniondfdate TEXT,
    category TEXT
);

-- Importer dans la table temporaire
COPY temp_import 
FROM '/tmp/Archives.csv' 
WITH (
    FORMAT CSV,
    DELIMITER ';',
    HEADER true,
    ENCODING 'UTF8',
    NULL ''
);

-- Insérer dans votre table avec conversion des dates
INSERT INTO public.archives (
    id, exoyear, arrivaldate, arrivalid, sendersce, 
    descentdate, reportid, summondate, actiontaken, 
    measures, findingof, applicantname, applicantaddress, 
    applicantcontact, locality, municipality, property0wner, 
    propertytitle, propertyname, pu, upr, zoning, surfacearea, 
    backfilledarea, xv, yv, minutesid, minutesdate, partsupplied, 
    submissiondate, destination, svr_fine, svr_roalty, invoicingid, 
    invoicingdate, fineamount, roaltyamount, convention, payementmethod, 
    daftransmissiondate, ref_quitus, sit_r, sit_a, commissiondate, 
    commissionopinion, recommandationobs, opfinal, opiniondfdate, category
)
SELECT 
    id,
    exoyear,
    CASE WHEN arrivaldate ~ '^\d{2}/\d{2}/\d{4}$' 
         THEN TO_DATE(arrivaldate, 'DD/MM/YYYY') 
         ELSE NULL END,
    arrivalid,
    sendersce,
    -- ... autres colonnes
    CASE WHEN commissiondate ~ '^\d{2}/\d{2}/\d{4}$' 
         THEN TO_DATE(commissiondate, 'DD/MM/YYYY') 
         ELSE NULL END,
    commissionopinion,
    recommandationobs,
    opfinal,
    CASE WHEN opiniondfdate ~ '^\d{2}/\d{2}/\d{4}$' 
         THEN TO_DATE(opiniondfdate, 'DD/MM/YYYY') 
         ELSE NULL END,
    category
FROM temp_import;

-- Nettoyer la table temporaire
DROP TABLE temp_import;