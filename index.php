<?php
$client_ip = $_SERVER['REMOTE_ADDR'] ?? 'neznámé';

function obnovCacheZGitu(string $repoDir, string $cachePath): bool {
    if (!function_exists('shell_exec')) return false;
    $cmd = 'cd ' . escapeshellarg($repoDir) . ' && git log --pretty=format:"%h%x1f%ad%x1f%an%x1f%s%x1f%b%x1e" --date=short 2>/dev/null';
    $out = @shell_exec($cmd);
    if (!$out) return false;
    return @file_put_contents($cachePath, $out) !== false;
}

function nactiHistoriiVerzi(string $repoDir): array {
    $cachePath = $repoDir . '/bordel/git-history.txt';

    // pokus o obnovení cache (pokud lze a cache je starší než 60s nebo neexistuje)
    $needsRefresh = !is_file($cachePath) || (time() - @filemtime($cachePath) > 60);
    if ($needsRefresh) {
        @obnovCacheZGitu($repoDir, $cachePath);
    }

    if (!is_file($cachePath)) return [];
    $out = @file_get_contents($cachePath);
    if (!$out) return [];

    $commits = [];
    foreach (array_filter(array_map('trim', explode("\x1e", $out))) as $rec) {
        $parts = explode("\x1f", $rec);
        if (count($parts) < 4) continue;
        $commits[] = [
            'hash'    => $parts[0],
            'date'    => $parts[1],
            'author'  => $parts[2],
            'subject' => $parts[3],
            'body'    => $parts[4] ?? '',
        ];
    }
    return $commits;
}

$commits = nactiHistoriiVerzi(__DIR__);
$totalCommits = count($commits);
?>
<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Autoškola - hlavní</title>
    <link rel="stylesheet" href="bordel/style.css?v=<?= @filemtime(__DIR__ . '/bordel/style.css') ?: time() ?>">
    <link rel="shortcut icon" href="bordel/favicon.png" type="image/png">
</head>
<body>
    <div id="warning-overlay" class="warning-overlay" style="display:none;">
        <div class="warning-dialog">
            <div class="warning-header">Varování&hellip;</div>
            <div class="warning-body">
                <div class="warning-icon">&#9888;</div>
                <div class="warning-text">
                    Předchozí spojení z adresy <?= htmlspecialchars($client_ip) ?> nebylo korektně ukončeno odhlášením.<br>
                    Hrozí porušení bezpečnosti Vašeho účtu nebo ztráta dat. < br>
                </div>
            </div>
            <div class="warning-footer">
                <button type="button" class="warning-ok" onclick="dismissWarning();">OK</button>
            </div>
        </div>
    </div>

    <header class="topbar">
        <div class="logo">auto<span>škola</span></div>
        <div class="user-info">
            <span class="user-name">Autoškola první řady</span>
            <a href="#" id="about-btn" class="logout" title="O aplikaci">&#x23FB;</a>
        </div>
    </header>

    <div id="about-overlay" class="warning-overlay" style="display:none;">
        <div class="warning-dialog">
            <div class="warning-header">O aplikaci</div>
            <div class="warning-body">
                <div class="warning-icon">&#9432;</div>
                <div class="warning-text">
                    <strong>Autoškola</strong> &mdash; informační systém pro správu studentů, instruktorů, vozidel a jízd autoškoly.<br><br>
                    Verze: <strong>1.0.<?= (int)$totalCommits ?></strong><br>
                    Aktuální klient: <?= htmlspecialchars($client_ip) ?>
                </div>
            </div>
            <div class="warning-footer">
                <button type="button" class="warning-ok" onclick="document.getElementById('about-overlay').style.display='none';">OK</button>
            </div>
        </div>
    </div>

    <div class="layout">
        <aside class="sidebar">
            <a href="#" class="sidebar-item active" data-pane="home">
                <span class="sidebar-icon">&#9432;</span>
                <span>O aplikaci</span>
            </a>
            <a href="#" class="sidebar-item" data-pane="vlozeni">
                <span class="sidebar-icon">+</span>
                <span>Vložení</span>
            </a>
            <a href="#" class="sidebar-item" data-pane="odebrani">
                <span class="sidebar-icon">&minus;</span>
                <span>Odebrání</span>
            </a>
            <a href="#" class="sidebar-item" data-pane="vypis">
                <span class="sidebar-icon">&#9776;</span>
                <span>Výpis</span>
            </a>
            <a href="#" class="sidebar-item" data-pane="administrativa">
                <span class="sidebar-icon">&#9881;</span>
                <span>Administrativa</span>
            </a>
        </aside>

        <main class="content">

            <section class="pane" id="pane-home">
                <nav class="tabs">
                    <a href="#" class="tab active" data-tab="main">O aplikaci</a>
                    <a href="#" class="tab" data-tab="main">Hlášení chyby</a>
                    <a href="#" class="tab" data-tab="help">Nápověda</a>
                </nav>
                <div class="help-content"><img src="bordel/bro.jpg" alt="Nápověda"></div>
                <div class="content-inner">
                    <div class="info-box">
                        Vítejte v informačním systému <strong>autoškola</strong>. Tato aplikace slouží pro správu studentů, instruktorů, vozidel a jízd autoškoly. V levém menu zvolte typ akce, kterou chcete provést. Některé části jsou stále ve vývoji a budou postupně doplňovány. Pokud zjistíte chybu, využijte záložku <strong>Hlášení chyby</strong>.<br><br>
                        Dostupné moduly (levá svislá navigace) umožňují vkládat, odebírat a vypisovat záznamy v systému. V sekci <strong>Administrativa</strong> najdete souhrnné výpisy.
                    </div>

                    <h2 class="version-title">Historie verzí</h2>

                    <?php if (empty($commits)): ?>
                        <p class="version-empty">Historii verzí se nepodařilo načíst &mdash; chybí cache soubor <code>bordel/git-history.txt</code>. Vygeneruj jej příkazem <code>git log --pretty=format:&quot;%h%x1f%ad%x1f%an%x1f%s%x1f%b%x1e&quot; --date=short &gt; bordel/git-history.txt</code>.</p>
                    <?php else: ?>
                        <?php foreach ($commits as $idx => $c):
                            $verNum = $totalCommits - $idx;
                            $version = '1.0.' . $verNum . ' (' . $c['hash'] . ')';
                        ?>
                            <div class="version-entry">
                                <div class="version-header">
                                    <strong><?= htmlspecialchars($version) ?></strong>, <?= htmlspecialchars($c['date']) ?>
                                    <span class="version-author">&mdash; <?= htmlspecialchars($c['author']) ?></span>
                                </div>
                                <ul class="version-changes">
                                    <li><?= htmlspecialchars($c['subject']) ?></li>
                                    <?php if (!empty($c['body'])): ?>
                                        <?php foreach (preg_split('/\r?\n/', $c['body']) as $line):
                                            $line = trim($line);
                                            if ($line === '' || $line === '---END---') continue;
                                            $line = preg_replace('/^[\-\*\u{2022}]\s*/u', '', $line);
                                        ?>
                                            <li><?= htmlspecialchars($line) ?></li>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </ul>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </section>

            <section class="pane hidden" id="pane-vlozeni">
                <nav class="tabs">
                    <a href="#" class="tab active" data-tab="main">Vložení záznamů</a>
                    <a href="#" class="tab" data-tab="help">Nápověda</a>
                </nav>
                <div class="help-content"><img src="bordel/bro.jpg" alt="Nápověda"></div>
                <div class="content-inner">
                    <div class="table-toolbar">
                        <span class="toolbar-label">Modul:</span>
                        <span class="toolbar-info">vyberte záznam pro vložení</span>
                    </div>
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th class="col-name">Název modulu</th>
                                <th class="col-desc">Popis</th>
                                <th class="col-action">Akce</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><span class="module-badge badge-add">+</span> Auta</td>
                                <td>Přidání nového vozidla do evidence</td>
                                <td><a class="row-link" href="forms/form-auta.php">Otevřít &rsaquo;</a></td>
                            </tr>
                            <tr>
                                <td><span class="module-badge badge-add">+</span> Instruktoři</td>
                                <td>Registrace nového instruktora</td>
                                <td><a class="row-link" href="forms/form-instruktori.php">Otevřít &rsaquo;</a></td>
                            </tr>
                            <tr>
                                <td><span class="module-badge badge-add">+</span> Studenti</td>
                                <td>Přidání nového žáka</td>
                                <td><a class="row-link" href="forms/form-studenti.php">Otevřít &rsaquo;</a></td>
                            </tr>
                            <tr>
                                <td><span class="module-badge badge-add">+</span> Jízdy</td>
                                <td>Záznam nové jízdy</td>
                                <td><a class="row-link" href="forms/form-jizdy.php">Otevřít &rsaquo;</a></td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="table-footer">Modulů 4</div>
                </div>
            </section>

            <section class="pane hidden" id="pane-odebrani">
                <nav class="tabs">
                    <a href="#" class="tab active" data-tab="main">Odebírání záznamů</a>
                    <a href="#" class="tab" data-tab="help">Nápověda</a>
                </nav>
                <div class="help-content"><img src="bordel/bro.jpg" alt="Nápověda"></div>
                <div class="content-inner">
                    <div class="table-toolbar">
                        <span class="toolbar-label">Modul:</span>
                        <span class="toolbar-info">vyberte záznam pro odebrání</span>
                    </div>
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th class="col-name">Název modulu</th>
                                <th class="col-desc">Popis</th>
                                <th class="col-action">Akce</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><span class="module-badge badge-del">&minus;</span> Auta</td>
                                <td>Odebrání vozidla z evidence</td>
                                <td><a class="row-link" href="forms_remove/form-auta.php">Otevřít &rsaquo;</a></td>
                            </tr>
                            <tr>
                                <td><span class="module-badge badge-del">&minus;</span> Instruktoři</td>
                                <td>Smazání instruktora</td>
                                <td><a class="row-link" href="forms_remove/form-instruktori.php">Otevřít &rsaquo;</a></td>
                            </tr>
                            <tr>
                                <td><span class="module-badge badge-del">&minus;</span> Studenti</td>
                                <td>Smazání žáka</td>
                                <td><a class="row-link" href="forms_remove/form-studenti.php">Otevřít &rsaquo;</a></td>
                            </tr>
                            <tr>
                                <td><span class="module-badge badge-del">&minus;</span> Jízdy</td>
                                <td>Odebrání záznamu jízdy</td>
                                <td><a class="row-link" href="forms_remove/form-jizdy.php">Otevřít &rsaquo;</a></td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="table-footer">Modulů 4</div>
                </div>
            </section>

            <section class="pane hidden" id="pane-vypis">
                <nav class="tabs">
                    <a href="#" class="tab active" data-tab="main">Výpis záznamů</a>
                    <a href="#" class="tab" data-tab="help">Nápověda</a>
                </nav>
                <div class="help-content"><img src="bordel/bro.jpg" alt="Nápověda"></div>
                <div class="content-inner">
                    <div class="table-toolbar">
                        <span class="toolbar-label">Modul:</span>
                        <span class="toolbar-info">vyberte záznam pro zobrazení</span>
                    </div>
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th class="col-name">Název modulu</th>
                                <th class="col-desc">Popis</th>
                                <th class="col-action">Akce</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><span class="module-badge badge-view">&#9776;</span> Auta</td>
                                <td>Přehled všech vozidel</td>
                                <td><a class="row-link" href="forms_display/form-auta.php">Otevřít &rsaquo;</a></td>
                            </tr>
                            <tr>
                                <td><span class="module-badge badge-view">&#9776;</span> Instruktoři</td>
                                <td>Seznam všech instruktorů</td>
                                <td><a class="row-link" href="forms_display/form-instruktori.php">Otevřít &rsaquo;</a></td>
                            </tr>
                            <tr>
                                <td><span class="module-badge badge-view">&#9776;</span> Studenti</td>
                                <td>Seznam všech žáků</td>
                                <td><a class="row-link" href="forms_display/form-studenti.php">Otevřít &rsaquo;</a></td>
                            </tr>
                            <tr>
                                <td><span class="module-badge badge-view">&#9776;</span> Jízdy</td>
                                <td>Přehled jízd</td>
                                <td><a class="row-link" href="forms_display/form-jizdy.php">Otevřít &rsaquo;</a></td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="table-footer">Modulů 4</div>
                </div>
            </section>

            <section class="pane hidden" id="pane-administrativa">
                <nav class="tabs">
                    <a href="#" class="tab active" data-tab="main">Administrativa</a>
                    <a href="#" class="tab" data-tab="help">Nápověda</a>
                </nav>
                <div class="help-content"><img src="bordel/bro.jpg" alt="Nápověda"></div>
                <div class="content-inner">
                    <div class="table-toolbar">
                        <span class="toolbar-label">Modul:</span>
                        <span class="toolbar-info">souhrnné a administrativní výpisy</span>
                    </div>
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th class="col-name">Název modulu</th>
                                <th class="col-desc">Popis</th>
                                <th class="col-action">Akce</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><span class="module-badge badge-admin">&#9881;</span> Souhrnný výpis</td>
                                <td>Kompletní administrativní přehled</td>
                                <td><a class="row-link" href="form_admin/form-administrativa.php">Otevřít &rsaquo;</a></td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="table-footer">Modulů 1</div>
                </div>
            </section>

        </main>
    </div>

    <script>
        function dismissWarning() {
            document.getElementById('warning-overlay').style.display = 'none';
        }
        document.getElementById('warning-overlay').style.display = 'flex';

        function switchPane(target) {
            if (!target) return false;
            var pane = document.getElementById('pane-' + target);
            if (!pane) return false;
            document.querySelectorAll('.sidebar-item').forEach(function (s) { s.classList.remove('active'); });
            var sidebarItem = document.querySelector('.sidebar-item[data-pane="' + target + '"]');
            if (sidebarItem) sidebarItem.classList.add('active');
            document.querySelectorAll('.pane').forEach(function (p) { p.classList.add('hidden'); });
            pane.classList.remove('hidden');
            return true;
        }

        document.querySelectorAll('.sidebar-item').forEach(function (item) {
            item.addEventListener('click', function (e) {
                e.preventDefault();
                var target = item.getAttribute('data-pane');
                if (switchPane(target)) {
                    history.replaceState(null, '', target === 'home' ? '#' : '#' + target);
                }
            });
        });

        (function applyHash() {
            var h = (window.location.hash || '').replace('#', '');
            if (h) switchPane(h);
        })();

        window.addEventListener('hashchange', function () {
            var h = (window.location.hash || '').replace('#', '');
            switchPane(h || 'home');
        });

        document.getElementById('about-btn').addEventListener('click', function (e) {
            e.preventDefault();
            switchPane('home');
            document.getElementById('about-overlay').style.display = 'flex';
        });

        document.querySelectorAll('.pane .tabs .tab').forEach(function (tab) {
            tab.addEventListener('click', function (e) {
                e.preventDefault();
                var pane = tab.closest('.pane');
                if (!pane) return;
                pane.querySelectorAll('.tabs .tab').forEach(function (t) { t.classList.remove('active'); });
                tab.classList.add('active');
                if (tab.getAttribute('data-tab') === 'help') {
                    pane.classList.add('show-help');
                } else {
                    pane.classList.remove('show-help');
                }
            });
        });
    </script>
</body>
</html>
