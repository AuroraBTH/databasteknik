<?php

$req_uri = $_SERVER['REQUEST_URI'];

if (strpos($req_uri, "?") !== false) {
    $path = substr($req_uri, 0, strrpos($req_uri, '?'));
    $path = basename($path);
} elseif (is_numeric(basename($req_uri))) {
    $path = substr($req_uri, 0, strrpos($req_uri, "/"));
    $path = basename($path);
} else {
    $path = basename($req_uri);
}


?>

<!doctype html>
<html class="<?= $path ?>">
<head>
    <meta charset="utf-8">
        <title><?= $title ?></title>

        <?php foreach ($stylesheets as $stylesheet) : ?>
        <link rel="stylesheet" type="text/css" href="<?= $this->asset($stylesheet) ?>">
        <?php endforeach; ?>

</head>
<body>

<?php if ($this->regionHasContent("header")) : ?>
<div class="header-wrap">
    <?php $this->renderRegion("header") ?>
</div>
<?php endif; ?>

<?php if ($this->regionHasContent("navbar")) : ?>
<div class="navbar-wrap">
    <?php $this->renderRegion("navbar") ?>
</div>
<?php endif; ?>

<?php if ($this->regionHasContent("main")) : ?>
<div class="main-wrap">
    <?php $this->renderRegion("main") ?>
</div>
<?php endif; ?>

<?php if ($this->regionHasContent("footer")) : ?>
<div class="footer-wrap">
    <?php $this->renderRegion("footer") ?>
</div>
<?php endif; ?>

</body>
</html>
