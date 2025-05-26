$ErrorActionPreference = "Stop"

$imageUrls = @(
    # Logo used across multiple pages
    "https://img.freepik.com/psd-premium/taube-png-taube-auf-transparentem-hintergrund-png-herunterladen_303714-5904.jpg",
    # Homepage background
    "https://i.imgur.com/WtWdQ9s.gif",
    # Photos products
    "https://www.allaboutbirds.org/guide/assets/photo/308074031-480px.jpg",
    "https://nas-national-prod.s3.amazonaws.com/styles/hero_image/s3/Rock-Pigeon_KK_APA_2011_27391_232647_DavidBroadwell.jpg",
    # Merch products
    "https://ih1.redbubble.net/image.1810514256.7019/ra,kids_tee,x900,FFFFFF:97ab1c12de,front-pad,750x1000,f8f8f8.jpg",
    "https://m.media-amazon.com/images/I/51cGg-0MugL._AC_UL1000_.jpg",
    "https://m.media-amazon.com/images/I/612fc5TOwIL._AC_UF1000,1000_QL80_.jpg",
    # Course products
    "https://cdn.pixabay.com/photo/2017/07/18/18/24/dove-2516641_1280.jpg",
    "https://upload.wikimedia.org/wikipedia/commons/thumb/4/4d/Rock_Pigeon_Columba_livia.jpg/1200px-Rock_Pigeon_Columba_livia.jpg"
)

$destinationFolder = "g:\pigeon-shop2\pigeon-shop2\assets\images\"

# Create hashtable to store URL to filename mappings
$urlToFilenameMap = @{}

# Download each image
foreach ($url in $imageUrls) {
    # Generate a filename based on the URL
    $filename = $url -split '/' | Select-Object -Last 1
    # If filename has query parameters, remove them
    $filename = $filename -split '\?' | Select-Object -First 1
    
    # Add a timestamp for uniqueness if needed
    if ($urlToFilenameMap.ContainsValue($filename)) {
        $timestamp = Get-Date -Format "yyyyMMddHHmmss"
        $extension = [System.IO.Path]::GetExtension($filename)
        $baseFilename = [System.IO.Path]::GetFileNameWithoutExtension($filename)
        $filename = "$baseFilename-$timestamp$extension"
    }
    
    $destination = Join-Path $destinationFolder $filename
    
    Write-Host "Downloading $url to $destination"
    
    try {
        Invoke-WebRequest -Uri $url -OutFile $destination
        # Store the mapping for later use
        $urlToFilenameMap[$url] = $filename
        Write-Host "Downloaded successfully"
    } catch {
        Write-Host "Failed to download $url. Error: $_"
    }
}

# Output the URL to filename mapping as JSON for use in replacement script
$jsonMap = ConvertTo-Json $urlToFilenameMap
$jsonMap | Out-File "g:\pigeon-shop2\pigeon-shop2\image_mapping.json"
Write-Host "Image mapping saved to g:\pigeon-shop2\pigeon-shop2\image_mapping.json"
