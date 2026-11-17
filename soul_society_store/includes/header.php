<?php
require_once __DIR__ . '/../config.php';
$user = currentUser();
$cartCount = array_sum($_SESSION['cart'] ?? []);
$pageTitle = $pageTitle ?? 'Soul Society Store';
?>
<!doctype html><html lang="pt-br"><head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= e($pageTitle) ?> | Soul Society Store</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<link href="<?= str_contains($_SERVER['PHP_SELF'], '/admin/') ? '../assets/css/style.css' : 'assets/css/style.css' ?>" rel="stylesheet">
</head><body>
<div class="topline">SOUL SOCIETY STORE <span>— EQUIPAMENTOS PARA TODO CEIFEIRO</span></div>
<nav class="navbar navbar-expand-lg navbar-dark site-nav"><div class="container">
<a class="navbar-brand" href="<?= str_contains($_SERVER['PHP_SELF'], '/admin/') ? '../index.php' : 'index.php' ?>">卍 <b>SOUL SOCIETY</b></a>
<button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#nav"><span class="navbar-toggler-icon"></span></button>
<div class="collapse navbar-collapse" id="nav"><ul class="navbar-nav ms-auto align-items-lg-center gap-lg-3">
<li><a class="nav-link" href="<?= str_contains($_SERVER['PHP_SELF'], '/admin/') ? '../index.php' : 'index.php' ?>">Início</a></li>
<li><a class="nav-link" href="<?= str_contains($_SERVER['PHP_SELF'], '/admin/') ? '../index.php#catalogo' : 'index.php#catalogo' ?>">Catálogo</a></li>
<li><a class="nav-link" href="<?= str_contains($_SERVER['PHP_SELF'], '/admin/') ? '../cart.php' : 'cart.php' ?>">Carrinho <span class="cart-pill"><?= (int)$cartCount ?></span></a></li>
<?php if ($user): ?>
<li><span class="nav-user">Olá, <?= e($user['name']) ?></span></li>
<?php if ($user['role'] === 'admin'): ?><li><a class="nav-link admin-link" href="<?= str_contains($_SERVER['PHP_SELF'], '/admin/') ? 'index.php' : 'admin/index.php' ?>">Painel</a></li><?php endif; ?>
<li><a class="nav-link" href="<?= str_contains($_SERVER['PHP_SELF'], '/admin/') ? '../logout.php' : 'logout.php' ?>">Sair</a></li>
<?php else: ?><li><a class="nav-link" href="<?= str_contains($_SERVER['PHP_SELF'], '/admin/') ? '../login.php' : 'login.php' ?>">Entrar</a></li><?php endif; ?>
</ul></div></div></nav>
<main>
