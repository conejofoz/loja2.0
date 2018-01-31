<h1>carrinho</h1>
<table border="0" width="100%">
    <tr>
        <th width="100">Imagem</th>
        <th>Nome</th>
        <th width="50">Qtd.</th>
        <th width="100">Preço</th>
        <th width="150" style="text-align: right">Sub-Total</th>
        <th width="50" style="text-align: right"></th>
    </tr>
    <?php
    $subtotal = 0;

    ;
    ?>
    <?php foreach ($list as $item): ?>
        <?php
        $subtotal += (floatval($item['price']) * intval($item['qt']));
        ;
        ?>
        <tr>
            <td><img src="<?php echo BASE_URL; ?>/media/products/<?php echo $item['image']; ?>" width="80" /></td>
            <td><?php echo $item['name']; ?></td>
            <td><?php echo $item['qt']; ?></td>
            <td>R$ <?php echo number_format($item['price'], 2, ',', '.'); ?></td>
            <td style="text-align: right">R$ <?php echo number_format($item['price'] * $item['qt'], 2, ',', '.'); ?></td>
            <td style="text-align: center"><a href="<?php echo BASE_URL; ?>cart/del/<?php echo $item['id']; ?>"><img src="<?php echo BASE_URL; ?>assets/images/delete.jpg" width="15" /></a></td>
        </tr>
<?php endforeach; ?>
    <tr>
        <td colspan="4" style="text-align: right">Sub-total: </td>
        <td style="text-align: right"><strong>R$ <?php echo number_format($subtotal, 2, ',', '.'); ?></strong> </td>
    </tr>
    <tr>
        <td colspan="4" style="text-align: right">Frete: </td>
        <td style="text-align: right">
            <?php if(isset($shipping['price'])): ?>
            <strong>R$ <?php echo $shipping['price']; ?></strong> (<?php echo $shipping['date']; ?> dia<?php echo ($shipping['date']==1)?'':'s'; ?>)
            <?php else: ?>
            Qual seu CEP?<br/>
            <form method="POST">
                <input type="number" name="cep" /><br/>
                <input type="submit" value="Calcular" /><br/>

            </form>
            <?php endif; ?>
        </td>
    </tr>
    <tr>
        <td colspan="4" style="text-align: right">Total: </td>
        <td style="text-align: right"><strong>R$ <?php 
        $frete = floatval(str_replace(',', '.',$shipping['price']));
        $total = $subtotal + $frete;
        echo number_format($total, 2, ',', '.'); ?></strong> </td>
    </tr>

</table>


<hr>
