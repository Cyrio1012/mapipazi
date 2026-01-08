# Script amélioré pour corriger les problèmes d'encodage
$inputFile = "Archives_clean_utf8.csv"
$outputFile = "Archives_clean_utf8_fixed.csv"

# Lire le fichier en UTF-8
$content = [System.IO.File]::ReadAllText($inputFile, [System.Text.Encoding]::UTF8)

# Statistiques avant correction
$statsBefore = @{
    'Arràªt' = ([regex]::Matches($content, 'Arràªt')).Count
    'arràªt' = ([regex]::Matches($content, 'arràªt')).Count
    'Joàªl' = ([regex]::Matches($content, 'Joàªl')).Count
}

Write-Host "Problèmes détectés avant correction :"
foreach ($key in $statsBefore.Keys) {
    if ($statsBefore[$key] -gt 0) {
        Write-Host "  - '$key' : $($statsBefore[$key]) occurrence(s)"
    }
}

# Corrections systématiques
$content = $content -replace 'Arràªt', 'Arrêt'
$content = $content -replace 'arràªt', 'arrêt'
$content = $content -replace 'ARRàªT', 'ARRÊT'
$content = $content -replace 'Joàªl', 'Joël'
$content = $content -replace 'joàªl', 'joël'

# Correction pour "l'arràªt" (avec apostrophe)
$content = $content -replace "l'arràªt", "l'arrêt"
$content = $content -replace "L'arràªt", "L'arrêt"

# Vérifier s'il reste des occurrences de "àª" dans d'autres contextes
$remaining = ([regex]::Matches($content, 'àª')).Count
if ($remaining -gt 0) {
    Write-Host "`nATTENTION : Il reste $remaining occurrence(s) de 'àª' non corrigée(s)"
    Write-Host "Recherche des occurrences restantes..."
    $matches = [regex]::Matches($content, 'àª')
    foreach ($match in $matches) {
        $context = $content.Substring([Math]::Max(0, $match.Index - 20), [Math]::Min(40, $content.Length - $match.Index + 20))
        Write-Host "  Contexte: ...$context..."
    }
}

# Écrire le fichier corrigé
[System.IO.File]::WriteAllText($outputFile, $content, [System.Text.UTF8Encoding]::new($true))

Write-Host "`nFichier corrigé créé : $outputFile"
Write-Host "Corrections appliquées avec succès !"

# Vérification après correction
$statsAfter = @{
    'Arràªt' = ([regex]::Matches($content, 'Arràªt')).Count
    'arràªt' = ([regex]::Matches($content, 'arràªt')).Count
    'Joàªl' = ([regex]::Matches($content, 'Joàªl')).Count
    'Arrêt' = ([regex]::Matches($content, 'Arrêt')).Count
    'Joël' = ([regex]::Matches($content, 'Joël')).Count
}

Write-Host "`nRésultats après correction :"
Write-Host "  - 'Arrêt' : $($statsAfter['Arrêt']) occurrence(s) (correct)"
Write-Host "  - 'Joël' : $($statsAfter['Joël']) occurrence(s) (correct)"
if ($statsAfter['Arràªt'] -eq 0 -and $statsAfter['arràªt'] -eq 0 -and $statsAfter['Joàªl'] -eq 0) {
    Write-Host "`n✓ Tous les problèmes d'encodage ont été corrigés !"
} else {
    Write-Host "`n⚠ Il reste encore quelques problèmes à corriger manuellement"
}