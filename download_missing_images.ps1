# Define the base URL for placeholder images
$baseUrl = "https://picsum.photos/800/600?random="

# Define the list of missing images and their new local paths
$missingImages = @(
    @{ Name = "fliegende-schoenheit.jpg"; DownloadUrl = "$($baseUrl)1" },
    @{ Name = "tauben-portrait.jpg"; DownloadUrl = "$($baseUrl)2" },
    @{ Name = "tauben-kaffeetasse.jpg"; DownloadUrl = "$($baseUrl)3" },
    @{ Name = "tauben-schluesselanhaenger.jpg"; DownloadUrl = "$($baseUrl)4" },
    @{ Name = "taubensprache-verstehen.jpg"; DownloadUrl = "$($baseUrl)5" }
)

# Define the local directory to save images
$localDir = "g:\pigeon-shop2\pigeon-shop2\assets\images"

# Create the directory if it doesn't exist
if (-not (Test-Path $localDir)) {
    New-Item -ItemType Directory -Path $localDir -Force
    Write-Host "Created directory: $localDir"
}

# Download each missing image
foreach ($image in $missingImages) {
    $localPath = Join-Path $localDir $image.Name
    try {
        Write-Host "Downloading $($image.DownloadUrl) to $localPath..."
        Invoke-WebRequest -Uri $image.DownloadUrl -OutFile $localPath
        Write-Host "Successfully downloaded $($image.Name)"
    } catch {
        Write-Error "Failed to download $($image.Name). Error: $_"
    }
}

Write-Host "Image download process complete."