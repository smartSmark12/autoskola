<?php
$pageTitle  = $pageTitle  ?? 'Autoškola';
$pageActive = $pageActive ?? '';
$pageHeading = $pageHeading ?? $pageTitle;

$rel = $rel ?? '../';

$sidebar = [
    ['key' => 'home',           'href' => $rel . 'index.php',                 'icon' => '&#9432;', 'label' => 'O aplikaci'],
    ['key' => 'vlozeni',        'href' => $rel . 'index.php#vlozeni',         'icon' => '+',       'label' => 'Vložení'],
    ['key' => 'odebrani',       'href' => $rel . 'index.php#odebrani',        'icon' => '&minus;', 'label' => 'Odebrání'],
    ['key' => 'vypis',          'href' => $rel . 'index.php#vypis',           'icon' => '&#9776;', 'label' => 'Výpis'],
    ['key' => 'administrativa', 'href' => $rel . 'index.php#administrativa', 'icon' => '&#9881;', 'label' => 'Administrativa'],
];

$tabs = $tabs ?? [['label' => $pageHeading, 'active' => true]];
?>
<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle) ?> &mdash; autoškola</title>
    <link rel="stylesheet" href="<?= $rel ?>bordel/style.css?v=<?= @filemtime(__DIR__ . '/style.css') ?: time() ?>">
</head>
<body>
    <header class="topbar">
        <div class="logo">auto<span>škola</span></div>
        <div class="user-info">
            <span class="user-name">Autoškola první řady</span>
            <a href="<?= $rel ?>index.php" class="logout" title="Domů">&#x23FB;</a>
        </div>
    </header>

    <div class="layout">
        <aside class="sidebar">
            <?php foreach ($sidebar as $item): ?>
                <a href="<?= htmlspecialchars($item['href']) ?>" class="sidebar-item<?= $pageActive === $item['key'] ? ' active' : '' ?>">
                    <span class="sidebar-icon"><?= $item['icon'] ?></span>
                    <span><?= htmlspecialchars($item['label']) ?></span>
                </a>
            <?php endforeach; ?>
        </aside>

        <main class="content">
            <section class="pane">
                <nav class="tabs">
                    <?php foreach ($tabs as $t): ?>
                        <a href="<?= htmlspecialchars($t['href'] ?? '#') ?>" class="tab<?= !empty($t['active']) ? ' active' : '' ?>"><?= htmlspecialchars($t['label']) ?></a>
                    <?php endforeach; ?>
                </nav>
                <div class="content-inner">
                    <h1 class="page-heading"><?= htmlspecialchars($pageHeading) ?></h1>
