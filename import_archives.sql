-- Se connecter à la base bddApipa et exécuter ce script
-- psql -h localhost -U csrpo -d bddApipa -f import_archives.sql

-- Vérifier si la contrainte PRIMARY KEY existe, sinon la créer
DO $$
BEGIN
    IF NOT EXISTS (
        SELECT 1 FROM pg_constraint 
        WHERE conname = 'archives_pkey' 
        AND conrelid = 'public.archives'::regclass
    ) THEN
        ALTER TABLE public.archives ADD PRIMARY KEY (id);
    END IF;
END $$;

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

-- Importer depuis le CSV (ajustez le chemin absolu)
-- Importer depuis le CSV (ajustez le chemin absolu)
COPY temp_import 
FROM 'E:/Workspace/mapipazi/mapipazi/Archives_clean_utf8.csv'
WITH (
    FORMAT CSV,
    DELIMITER ';',
    HEADER true,
    ENCODING 'UTF8',
    NULL ''
);

-- Fonction pour convertir les dates
CREATE OR REPLACE FUNCTION parse_date(date_str TEXT) RETURNS DATE AS $$
BEGIN
    IF date_str IS NULL OR date_str = '' THEN
        RETURN NULL;
    END IF;
    
    IF date_str ~ '^\d{2}/\d{2}/\d{4}$' THEN
        RETURN TO_DATE(date_str, 'DD/MM/YYYY');
    END IF;
    
    RETURN NULL;
EXCEPTION
    WHEN OTHERS THEN
        RETURN NULL;
END;
$$ LANGUAGE plpgsql;

-- Insérer dans la table archives avec conversion
INSERT INTO public.archives (
    id, exoyear, arrivaldate, arrivalid, sendersce, 
    descentdate, reportid, summondate, actiontaken, 
    measures, findingof, applicantname, applicantaddress, 
    applicantcontact, locality, municipality, property0wner, 
    propertytitle, propertyname, urbanplanningregulations, upr, zoning, 
    surfacearea, backfilledarea, xv, yv, minutesid, minutesdate, 
    partsupplied, submissiondate, destination, svr_fine, svr_roalty, 
    invoicingid, invoicingdate, fineamount, roaltyamount, convention, 
    payementmethod, daftransmissiondate, ref_quitus, sit_r, sit_a, 
    commissiondate, commissionopinion, recommandationobs, opfinal, 
    opiniondfdate, category
)
-- SELECT 
--     CASE WHEN id ~ '^\d+$' THEN id::INTEGER ELSE NULL END,
--     CASE WHEN exoyear ~ '^\d+$' THEN exoyear::INTEGER ELSE NULL END,
--     parse_date(arrivaldate),
--     NULLIF(TRIM(arrivalid), ''),
--     NULLIF(TRIM(sendersce), ''),
--     parse_date(descentdate),
--     NULLIF(TRIM(reportid), ''),
--     parse_date(summondate),
--     NULLIF(TRIM(actiontaken), ''),
--     NULLIF(TRIM(measures), ''),
--     NULLIF(TRIM(findingof), ''),
--     NULLIF(TRIM(applicantname), ''),
--     NULLIF(TRIM(applicantaddress), ''),
--     NULLIF(TRIM(applicantcontact), ''),
--     NULLIF(TRIM(locality), ''),
--     NULLIF(TRIM(municipality), ''),
--     NULLIF(TRIM(property0wner), ''),
--     NULLIF(TRIM(propertytitle), ''),
--     NULLIF(TRIM(propertyname), ''),
--     NULLIF(TRIM(pu), ''), -- urbanplanningregulations
--     NULLIF(TRIM(upr), ''),
--     NULLIF(TRIM(zoning), ''),
--     CASE WHEN surfacearea ~ '^\d+(\.\d+)?$' THEN surfacearea::DECIMAL ELSE NULL END,
--     CASE WHEN backfilledarea ~ '^\d+(\.\d+)?$' THEN backfilledarea::DECIMAL ELSE NULL END,
--     CASE WHEN xv ~ '^-?\d+(\.\d+)?$' THEN xv::DOUBLE PRECISION ELSE NULL END,
--     CASE WHEN yv ~ '^-?\d+(\.\d+)?$' THEN yv::DOUBLE PRECISION ELSE NULL END,
--     NULLIF(TRIM(minutesid), ''),
--     parse_date(minutesdate),
--     NULLIF(TRIM(partsupplied), ''),
--     parse_date(submissiondate),
--     NULLIF(TRIM(destination), ''),
--     CASE WHEN svr_fine ~ '^\d+(\.\d+)?$' THEN svr_fine::DECIMAL ELSE NULL END,
--     CASE WHEN svr_roalty ~ '^\d+(\.\d+)?$' THEN svr_roalty::DECIMAL ELSE NULL END,
--     NULLIF(TRIM(invoicingid), ''),
--     parse_date(invoicingdate),
--     CASE WHEN fineamount ~ '^\d+(\.\d+)?$' THEN fineamount::DECIMAL ELSE NULL END,
--     CASE WHEN roaltyamount ~ '^\d+(\.\d+)?$' THEN roaltyamount::DECIMAL ELSE NULL END,
--     NULLIF(TRIM(convention), ''),
--     NULLIF(TRIM(payementmethod), ''),
--     parse_date(daftransmissiondate),
--     NULLIF(TRIM(ref_quitus), ''),
--     NULLIF(TRIM(sit_r), ''),
--     NULLIF(TRIM(sit_a), ''),
--     parse_date(commissiondate),
--     NULLIF(TRIM(commissionopinion), ''),
--     NULLIF(TRIM(recommandationobs), ''),
--     NULLIF(TRIM(opfinal), ''),
--     parse_date(opiniondfdate),
--     NULLIF(TRIM(category), '')

SELECT 
    CASE WHEN id ~ '^\d+$' THEN id::INTEGER ELSE NULL END,
    CASE WHEN exoyear ~ '^\d+$' THEN exoyear::INTEGER ELSE NULL END,
    parse_date(arrivaldate),
    NULLIF(SUBSTRING(TRIM(arrivalid), 1, 255), ''),
    NULLIF(SUBSTRING(TRIM(sendersce), 1, 255), ''),
    parse_date(descentdate),
    NULLIF(SUBSTRING(TRIM(reportid), 1, 255), ''),
    parse_date(summondate),
    NULLIF(SUBSTRING(TRIM(actiontaken), 1, 500), ''), -- 500 selon le modèle
    NULLIF(SUBSTRING(TRIM(measures), 1, 255), ''),
    NULLIF(SUBSTRING(TRIM(findingof), 1, 72), ''), -- 72 selon le modèle
    NULLIF(SUBSTRING(TRIM(applicantname), 1, 250), ''), -- 250 selon le modèle
    NULLIF(SUBSTRING(TRIM(applicantaddress), 1, 250), ''), -- 250 selon le modèle
    NULLIF(SUBSTRING(TRIM(applicantcontact), 1, 255), ''),
    NULLIF(SUBSTRING(TRIM(locality), 1, 255), ''),
    NULLIF(SUBSTRING(TRIM(municipality), 1, 255), ''),
    NULLIF(SUBSTRING(TRIM(property0wner), 1, 255), ''),
    NULLIF(SUBSTRING(TRIM(propertytitle), 1, 255), ''),
    NULLIF(SUBSTRING(TRIM(propertyname), 1, 255), ''),
    NULLIF(SUBSTRING(TRIM(pu), 1, 255), ''), -- urbanplanningregulations
    NULLIF(SUBSTRING(TRIM(upr), 1, 255), ''),
    NULLIF(SUBSTRING(TRIM(zoning), 1, 255), ''),
    CASE WHEN surfacearea ~ '^\d+(\.\d+)?$' THEN surfacearea::DECIMAL ELSE NULL END,
    CASE WHEN backfilledarea ~ '^\d+(\.\d+)?$' THEN backfilledarea::DECIMAL ELSE NULL END,
    CASE WHEN xv ~ '^-?\d+(\.\d+)?$' THEN xv::DOUBLE PRECISION ELSE NULL END,
    CASE WHEN yv ~ '^-?\d+(\.\d+)?$' THEN yv::DOUBLE PRECISION ELSE NULL END,
    NULLIF(SUBSTRING(TRIM(minutesid), 1, 255), ''),
    parse_date(minutesdate),
    NULLIF(SUBSTRING(TRIM(partsupplied), 1, 255), ''),
    parse_date(submissiondate),
    NULLIF(SUBSTRING(TRIM(destination), 1, 255), ''),
    CASE WHEN svr_fine ~ '^\d+(\.\d+)?$' THEN svr_fine::DECIMAL ELSE NULL END,
    CASE WHEN svr_roalty ~ '^\d+(\.\d+)?$' THEN svr_roalty::DECIMAL ELSE NULL END,
    NULLIF(SUBSTRING(TRIM(invoicingid), 1, 255), ''),
    parse_date(invoicingdate),
    CASE WHEN fineamount ~ '^\d+(\.\d+)?$' THEN fineamount::DECIMAL ELSE NULL END,
    CASE WHEN roaltyamount ~ '^\d+(\.\d+)?$' THEN roaltyamount::DECIMAL ELSE NULL END,
    NULLIF(SUBSTRING(TRIM(convention), 1, 255), ''),
    NULLIF(SUBSTRING(TRIM(payementmethod), 1, 255), ''),
    parse_date(daftransmissiondate),
    NULLIF(SUBSTRING(TRIM(ref_quitus), 1, 255), ''),
    NULLIF(SUBSTRING(TRIM(sit_r), 1, 255), ''),
    NULLIF(SUBSTRING(TRIM(sit_a), 1, 255), ''),
    parse_date(commissiondate),
    NULLIF(SUBSTRING(TRIM(commissionopinion), 1, 255), ''),
    NULLIF(SUBSTRING(TRIM(recommandationobs), 1, 255), ''),
    NULLIF(SUBSTRING(TRIM(opfinal), 1, 255), ''),
    parse_date(opiniondfdate),
    NULLIF(SUBSTRING(TRIM(category), 1, 255), '')

-- Option 1 : si on veut ignorer les doublons
--FROM temp_import
-- ON CONFLICT (id) DO NOTHING; choix 1

-- Option 2 : sin on veut mettre à jour les enregistrements existants
--FROM temp_import
-- ON CONFLICT (id) DO UPDATE SET
--     exoyear = EXCLUDED.exoyear,
--     arrivaldate = EXCLUDED.arrivaldate,
--     arrivalid = EXCLUDED.arrivalid,
--     sendersce = EXCLUDED.sendersce,
--     descentdate = EXCLUDED.descentdate,
--     reportid = EXCLUDED.reportid,
--     summondate = EXCLUDED.summondate,
--     actiontaken = EXCLUDED.actiontaken,
--     measures = EXCLUDED.measures,
--     findingof = EXCLUDED.findingof,
--     applicantname = EXCLUDED.applicantname,
--     applicantaddress = EXCLUDED.applicantaddress,
--     applicantcontact = EXCLUDED.applicantcontact,
--     locality = EXCLUDED.locality,
--     municipality = EXCLUDED.municipality,
--     property0wner = EXCLUDED.property0wner,
--     propertytitle = EXCLUDED.propertytitle,
--     propertyname = EXCLUDED.propertyname,
--     urbanplanningregulations = EXCLUDED.urbanplanningregulations,
--     upr = EXCLUDED.upr,
--     zoning = EXCLUDED.zoning,
--     surfacearea = EXCLUDED.surfacearea,
--     backfilledarea = EXCLUDED.backfilledarea,
--     xv = EXCLUDED.xv,
--     yv = EXCLUDED.yv,
--     minutesid = EXCLUDED.minutesid,
--     minutesdate = EXCLUDED.minutesdate,
--     partsupplied = EXCLUDED.partsupplied,
--     submissiondate = EXCLUDED.submissiondate,
--     destination = EXCLUDED.destination,
--     svr_fine = EXCLUDED.svr_fine,
--     svr_roalty = EXCLUDED.svr_roalty,
--     invoicingid = EXCLUDED.invoicingid,
--     invoicingdate = EXCLUDED.invoicingdate,
--     fineamount = EXCLUDED.fineamount,
--     roaltyamount = EXCLUDED.roaltyamount,
--     convention = EXCLUDED.convention,
--     payementmethod = EXCLUDED.payementmethod,
--     daftransmissiondate = EXCLUDED.daftransmissiondate,
--     ref_quitus = EXCLUDED.ref_quitus,
--     sit_r = EXCLUDED.sit_r,
--     sit_a = EXCLUDED.sit_a,
--     commissiondate = EXCLUDED.commissiondate,
--     commissionopinion = EXCLUDED.commissionopinion,
--     recommandationobs = EXCLUDED.recommandationobs,
--     opfinal = EXCLUDED.opfinal,
--     opiniondfdate = EXCLUDED.opiniondfdate,
--     category = EXCLUDED.category;

-- Option 3 : si on nettoyer avant d'importer
FROM temp_import
WHERE NOT EXISTS (
    SELECT 1 FROM public.archives 
    WHERE archives.id = temp_import.id::INTEGER
);

-- Nettoyer
DROP FUNCTION IF EXISTS parse_date(TEXT);
DROP TABLE temp_import;