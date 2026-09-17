$ErrorActionPreference = 'Stop'
$ProgressPreference = 'SilentlyContinue'
[Net.ServicePointManager]::SecurityProtocol = [Net.SecurityProtocolType]::Tls12

# Ang Invoke-WebRequest ng PS 5.1 ay nagde-decode ng sagot bilang Latin-1 kapag
# walang charset sa header, kaya nagiging "Ã±" ang "ñ" (Doña, Niño, Peñaranda).
# Tahasang UTF-8 ang gamit dito para tama ang mga pangalan.
function Get-Json([string]$url) {
    $wc = New-Object System.Net.WebClient
    $wc.Encoding = [System.Text.Encoding]::UTF8
    try { return $wc.DownloadString($url) | ConvertFrom-Json }
    finally { $wc.Dispose() }
}

# Mga lalawigang kinokolekta: kung saan talaga nanggagaling ang pasyente ng
# Marilao, Bulacan na klinika. Ang NCR ay region, hindi province, kaya iba
# ang endpoint niya.
$sources = @(
    @{ label = 'Bulacan';       lgu = 'https://psgc.gitlab.io/api/provinces/031400000/cities-municipalities.json'; brgy = 'https://psgc.gitlab.io/api/provinces/031400000/barangays.json' },
    @{ label = 'Metro Manila';  lgu = 'https://psgc.gitlab.io/api/regions/130000000/cities-municipalities.json';   brgy = 'https://psgc.gitlab.io/api/regions/130000000/barangays.json' },
    @{ label = 'Pampanga';      lgu = 'https://psgc.gitlab.io/api/provinces/035400000/cities-municipalities.json'; brgy = 'https://psgc.gitlab.io/api/provinces/035400000/barangays.json' },
    @{ label = 'Nueva Ecija';   lgu = 'https://psgc.gitlab.io/api/provinces/034900000/cities-municipalities.json'; brgy = 'https://psgc.gitlab.io/api/provinces/034900000/barangays.json' },
    @{ label = 'Rizal';         lgu = 'https://psgc.gitlab.io/api/provinces/045800000/cities-municipalities.json'; brgy = 'https://psgc.gitlab.io/api/provinces/045800000/barangays.json' }
)

function Clean-Name([string]$n) {
    $n = $n -replace '\s*\(Capital\)\s*$', ''
    if ($n -match '^City of (.+)$') { $n = $Matches[1] + ' City' }
    return $n.Trim()
}

$out = [ordered]@{}
$orphans = 0

foreach ($src in $sources) {
    Write-Host "Fetching $($src.label)..."
    $lgus   = Get-Json $src.lgu
    $brgys  = Get-Json $src.brgy

    # code -> display name, at sub-municipality (mga distrito ng Maynila) -> magulang na lungsod
    $lguByCode = @{}
    foreach ($l in $lgus) { $lguByCode[$l.code] = (Clean-Name $l.name) }

    $subToParent = @{}
    try {
        $subs = Get-Json 'https://psgc.gitlab.io/api/sub-municipalities.json'
        foreach ($s in $subs) { $subToParent[$s.code] = $s.cityCode }
    } catch { }

    $prov = [ordered]@{}
    foreach ($b in $brgys) {
        $key = $null
        if ($b.cityCode)         { $key = $b.cityCode }
        elseif ($b.municipalityCode) { $key = $b.municipalityCode }
        elseif ($b.subMunicipalityCode -and $subToParent.ContainsKey($b.subMunicipalityCode)) {
            $key = $subToParent[$b.subMunicipalityCode]
        }

        if (-not $key -or -not $lguByCode.ContainsKey($key)) { $orphans++; continue }

        $lguName = $lguByCode[$key]
        if (-not $prov.Contains($lguName)) { $prov[$lguName] = [System.Collections.ArrayList]::new() }
        [void]$prov[$lguName].Add((Clean-Name $b.name))
    }

    # Pinag-uuri-uri para madaling hanapin sa dropdown
    $sorted = [ordered]@{}
    foreach ($k in ($prov.Keys | Sort-Object)) {
        $sorted[$k] = @($prov[$k] | Sort-Object -Unique)
    }
    $out[$src.label] = $sorted

    $total = ($sorted.Values | ForEach-Object { $_.Count } | Measure-Object -Sum).Sum
    Write-Host ("  {0}: {1} LGUs, {2} barangays" -f $src.label, $sorted.Count, $total)
}

Write-Host "Orphan barangays skipped: $orphans"

$json = $out | ConvertTo-Json -Depth 6 -Compress
$header = @"
/**
 * Philippine address reference data (PSGC) para sa cascading dropdowns:
 * Province -> City/Municipality -> Barangay.
 *
 * Saklaw: Bulacan at mga karatig na lalawigan kung saan nanggagaling ang mga
 * pasyente ng klinika. Kung kailangang palawakin o i-refresh, baguhin ang
 * \$sources sa resources/data/build-ph-address.ps1 at patakbuhin muli ito.
 * Pinagmulan: https://psgc.gitlab.io/api/
 *
 * BUO ITONG GENERATED — huwag i-edit nang manu-mano.
 */
window.PH_ADDRESS =
"@

$utf8 = New-Object System.Text.UTF8Encoding($false)
# Nasa resources/data/ ang script na ito, kaya dalawang antas pataas ang ugat.
$root = (Resolve-Path (Join-Path $PSScriptRoot '..\..')).Path

function Write-Generated([string]$relative, [string]$content) {
    $full = Join-Path $root $relative
    $dir  = Split-Path $full -Parent
    if (-not (Test-Path $dir)) { New-Item -ItemType Directory -Force $dir | Out-Null }
    [System.IO.File]::WriteAllText($full, $content, $utf8)
    Write-Host ("Written: {0} ({1:N0} bytes)" -f $relative, (Get-Item $full).Length)
}

# Dalawang labasan mula sa iisang pinagmulan:
#   - JS para sa cascading dropdowns sa browser (static, naka-cache).
#   - JSON para sa server-side validation (App\Services\PhAddress).
Write-Generated 'public\js\ph-address.js'     ($header + $json + ";`n")
Write-Generated 'resources\data\ph-address.json' ($json + "`n")
