<!DOCTYPE html>
<html lang="de">
<head>
<meta charset="UTF-8">
<title><?php echo $title ?? 'Pigeon Shop'; ?></title>
<link rel="stylesheet" href="/css/style.css">
</head>
<body>
<?php include __DIR__.'/header.php'; ?>
<div class="container">
<?php echo $content ?? ''; ?>
</div>
<?php include __DIR__.'/footer.php'; ?>
<script src="/js/main.js"></script>
</body>
</html>
