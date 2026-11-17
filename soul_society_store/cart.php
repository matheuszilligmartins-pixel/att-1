<?php
require_once 'config.php';verifyCsrf();
$_SESSION['cart']=$_SESSION['cart']??[];
if($_SERVER['REQUEST_METHOD']==='POST'){
$action=$_POST['action']??'';
if($action==='add'){$id=(int)($_POST['product_id']??0);$qty=max(1,(int)($_POST['quantity']??1));$s=$pdo->prepare("SELECT stock FROM products WHERE id=? AND active=1");$s->execute([$id]);$p=$s->fetch();if($p&&$p['stock']>0){$_SESSION['cart'][$id]=min($p['stock'],($_SESSION['cart'][$id]??0)+$qty);}}
if($action==='update'){foreach(($_POST['qty']??[]) as $id=>$qty){$id=(int)$id;$s=$pdo->prepare("SELECT stock FROM products WHERE id=?");$s->execute([$id]);$p=$s->fetch();if(!$p||$qty<=0)unset($_SESSION['cart'][$id]);else $_SESSION['cart'][$id]=min((int)$qty,(int)$p['stock']);}}
if($action==='remove')unset($_SESSION['cart'][(int)($_POST['product_id']??0)]);
redirect('cart.php');
}
$items=[];$total=0;
if($_SESSION['cart']){$ids=array_keys($_SESSION['cart']);$marks=implode(',',array_fill(0,count($ids),'?'));$s=$pdo->prepare("SELECT * FROM products WHERE id IN ($marks) AND active=1");$s->execute($ids);foreach($s->fetchAll() as $p){$qty=$_SESSION['cart'][$p['id']];$p['quantity']=$qty;$p['subtotal']=$qty*$p['price'];$total+=$p['subtotal'];$items[]=$p;}}
$pageTitle='Carrinho';include 'includes/header.php';?>
<div class="page-head"><div class="container"><div class="section-kicker">SUA SELEÇÃO</div><h1>CARRINHO DE COMPRAS</h1></div></div><section class="section"><div class="container">
<?php if(!$items): ?><div class="dark-panel text-center"><h2 class="section-title">SEU CARRINHO ESTÁ VAZIO</h2><p class="muted">Sua próxima aventura começa escolhendo seus itens.</p><a class="btn-red" href="index.php#catalogo">EXPLORAR PRODUTOS</a></div>
<?php else: ?><form method="post"><input type="hidden" name="csrf" value="<?= e(csrfToken()) ?>"><input type="hidden" name="action" value="update"><div class="table-responsive"><table class="table table-dark align-middle"><thead><tr><th>Produto</th><th>Preço</th><th style="width:130px">Quantidade</th><th>Subtotal</th><th></th></tr></thead><tbody><?php foreach($items as $p): ?><tr><td><?= e($p['name']) ?></td><td><?= money($p['price']) ?></td><td><input class="form-control quantity-input" type="number" min="0" max="<?= $p['stock'] ?>" name="qty[<?= $p['id'] ?>]" value="<?= $p['quantity'] ?>"></td><td><?= money($p['subtotal']) ?></td><td><button class="btn btn-sm btn-outline-danger" form="remove<?= $p['id'] ?>">Remover</button></td></tr><?php endforeach; ?></tbody></table></div><button class="btn-outline">ATUALIZAR CARRINHO</button></form>
<?php foreach($items as $p): ?><form id="remove<?= $p['id'] ?>" method="post"><input type="hidden" name="csrf" value="<?= e(csrfToken()) ?>"><input type="hidden" name="action" value="remove"><input type="hidden" name="product_id" value="<?= $p['id'] ?>"></form><?php endforeach; ?>
<div class="dark-panel ms-auto mt-4" style="max-width:420px"><div class="d-flex justify-content-between mb-3"><span class="muted">Total geral</span><strong class="price"><?= money($total) ?></strong></div><a class="btn-red d-block text-center" href="checkout.php">CONTINUAR PARA PAGAMENTO</a></div><?php endif; ?></div></section><?php include 'includes/footer.php'; ?>
