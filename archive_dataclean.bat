$inputFile = "Archives_comma.csv"
$outputFile = "Archives_comma_cleaned.csv"

# Lire le fichier
$content = Get-Content $inputFile -Raw -Encoding UTF8

# Remplacer les sauts de ligne dans les champs entre guillemets par des espaces
$lines = $content -split "`r?`n"
$cleanedLines = @()
$inQuotedField = $false
$currentLine = ""

foreach ($line in $lines) {
    $quoteCount = ($line.ToCharArray() | Where-Object { $_ -eq '"' }).Count
    if ($quoteCount % 2 -eq 1) {
        $inQuotedField = -not $inQuotedField
    }
    
    if ($inQuotedField) {
        # Remplacer les sauts de ligne par un espace
        $cleanedLine = $line -replace "`r`n|`r|`n", " "
        $currentLine += $cleanedLine + " "
    }
    else {
        if ($currentLine) {
            $currentLine += $line -replace "`r`n|`r|`n", " "
            $cleanedLines += $currentLine
            $currentLine = ""
        }
        else {
            $cleanedLine = $line -replace "`r`n|`r|`n", " "
            $cleanedLines += $cleanedLine
        }
    }
}

if ($currentLine) {
    $cleanedLines += $currentLine
}

# Nettoyer les espaces multiples dans chaque ligne
$finalLines = $cleanedLines | ForEach-Object {
    if ($_.Trim()) {
        # Remplacer les espaces multiples par un seul espace
        ($_ -replace '\s+', ' ').Trim()
    }
}

# Écrire le fichier nettoyé
$finalLines | Set-Content $outputFile -Encoding UTF8

Write-Host "Fichier nettoyé créé : $outputFile"