<?php
require_once 'config.php';$id=(int)($_GET['id']??0);
$stmt=$pdo->prepare("SELECT p.*,c.name category FROM products p JOIN categories c ON c.id=p.category_id WHERE p.id=? AND p.active=1");$stmt->execute([$id]);$p=$stmt->fetch();
if(!$p){http_response_code(404);exit('Produto não encontrado.');}
$pageTitle=$p['name'];include 'includes/header.php';
?>
<div class="page-head"><div class="container"><div class="section-kicker">ARQUIVO DE PRODUTO / <?= e($p['category']) ?></div><h1><?= e($p['name']) ?></h1></div></div>
<section class="section"><div class="container"><div class="row g-5 align-items-center">
<div class="col-lg-6"><?php if($p['image']): ?><img class="detail-image" src="<?= e($p['image']) ?>" alt="<?= e($p['name']) ?>"><?php else: ?><div class="detail-image d-flex align-items-center justify-content-center"><span class="product-placeholder">卍</span></div><?php endif; ?></div>
<div class="col-lg-6"><div class="category"><?= e($p['category']) ?></div><h2 class="section-title"><?= e($p['name']) ?></h2><p class="muted"><?= nl2br(e($p['description'])) ?></p><div class="price fs-3 my-3"><?= money($p['price']) ?></div><p class="stock"><?= $p['stock']>0?'Disponibilidade: '.$p['stock'].' unidade(s)':'Produto indisponível' ?></p>
<?php if($p['stock']>0): ?><form method="post" action="cart.php" class="d-flex gap-2 mt-4"><?php csrfToken(); ?><input type="hidden" name="csrf" value="<?= e(csrfToken()) ?>"><input type="hidden" name="action" value="add"><input type="hidden" name="product_id" value="<?= $p['id'] ?>"><input class="form-control" style="max-width:90px" type="number" min="1" max="<?= $p['stock'] ?>" name="quantity" value="1"><button class="btn-red">ADICIONAR AO CARRINHO</button></form><?php endif; ?>
<a class="btn-outline d-inline-block mt-3" href="index.php#catalogo">VOLTAR AO CATÁLOGO</a></div></div></div></section>
<?php include 'includes/footer.php'; ?>
