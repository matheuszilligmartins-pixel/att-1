<?php
require_once 'config.php';
$pageTitle='Início';
$search=trim($_GET['q'] ?? '');
$category=(int)($_GET['category'] ?? 0);
$sql="SELECT p.*, c.name category FROM products p JOIN categories c ON c.id=p.category_id WHERE p.active=1";
$params=[];
if($search!==''){ $sql.=" AND (p.name LIKE ? OR p.description LIKE ?)"; $params[]="%$search%";$params[]="%$search%"; }
if($category>0){$sql.=" AND p.category_id=?";$params[]=$category;}
$sql.=" ORDER BY p.created_at DESC";
$stmt=$pdo->prepare($sql);$stmt->execute($params);$products=$stmt->fetchAll();
$categories=$pdo->query("SELECT * FROM categories ORDER BY name")->fetchAll();
include 'includes/header.php';
?>
<section class="hero"><div class="container"><div class="hero-content">
<div class="eyebrow">BEM-VINDO À SOUL SOCIETY</div><h1>LIBERE SEU<br><span>BANKAI.</span></h1>
<p>Vista sua paixão pelo universo de Bleach. Encontre colecionáveis, acessórios e produtos inspirados nos maiores Shinigamis.</p>
<a class="btn-red me-2" href="#catalogo">EXPLORAR CATÁLOGO</a><a class="btn-outline" href="register.php">CRIAR CONTA</a>
</div></div></section>
<section class="section" id="catalogo"><div class="container">
<div class="section-kicker">ESCOLHA SEU CAMINHO</div><h2 class="section-title">CATÁLOGO DA SOUL SOCIETY</h2>
<form class="row g-2 mb-4" method="get">
<div class="col-md-6"><input class="form-control" name="q" placeholder="Buscar produtos..." value="<?= e($search) ?>"></div>
<div class="col-md-4"><select class="form-select" name="category"><option value="0">Todas as categorias</option><?php foreach($categories as $c): ?><option value="<?= $c['id'] ?>" <?= $category===$c['id']?'selected':'' ?>><?= e($c['name']) ?></option><?php endforeach; ?></select></div>
<div class="col-md-2 d-grid"><button class="btn-red">FILTRAR</button></div></form>
<div class="row g-4"><?php foreach($products as $p): ?><div class="col-6 col-lg-4"><article class="product-card">
<a href="product.php?id=<?= $p['id'] ?>"><div class="product-img"><?php if($p['image']): ?><img src="<?= e($p['image']) ?>" alt="<?= e($p['name']) ?>"><?php else: ?><span class="product-placeholder">卍</span><?php endif; ?></div></a>
<div class="product-info"><div class="category"><?= e($p['category']) ?></div><h3 class="product-name"><?= e($p['name']) ?></h3><div class="price"><?= money($p['price']) ?></div><div class="stock mb-3"><?= $p['stock']>0?'Em estoque: '.$p['stock']:'Esgotado' ?></div><a class="btn-red d-block text-center" href="product.php?id=<?= $p['id'] ?>">VER PRODUTO</a></div>
</article></div><?php endforeach; ?></div>
<?php if(!$products): ?><p class="muted mt-4">Nenhum produto encontrado. Tente outra busca.</p><?php endif; ?>
</div></section>
<?php include 'includes/footer.php'; ?>
