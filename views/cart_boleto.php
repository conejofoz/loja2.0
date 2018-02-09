<h1>Checkout Boleto Bancário</h1>
<?php if(!empty($error)) : ?>
<div class="warn">
    <?php echo $error;?>
</div>
<?php endif;?>

<form method="POST" 

    <h3>Dados pessoais</h3>
    
    <strong>Nome:</strong><br/>
    <input type="text" name="name" value="Silvio Coelho" /><br/><br/>
    
    <strong>CPF</strong><br/>
    <input type="text" name="cpf" value="05347965401" /><br/><br/>
    
    <strong>Telefone</strong><br/>
    <input type="text" name="telefone" value="4535274977" /><br/><br/>
    
    <strong>E-mail</strong><br/>
    <input type="email" name="email" value="conejofoz@gmail.com" /><br/><br/>
    
    <strong>Senha</strong><br/>
    <input type="password" name="pass" value="123" /><br/><br/>
    
    <h3>Informacoes de endereco</h3>
    
    <strong>CEP</strong><br/>
    <input type="text" name="cep" value="85854516" /><br/><br/>
    
    <strong>Rua</strong><br/>
    <input type="text" name="rua" value="Rua das Flores" /><br/><br/>
    
    <strong>Numero</strong><br/>
    <input type="text" name="numero" value="320" /><br/><br/>
    
    <strong>Complemento</strong><br/>
    <input type="text" name="complemento" value="casa" /><br/><br/>
    
    <strong>Bairro</strong><br/>
    <input type="text" name="bairro" value="Centro" /><br/><br/>
    
    <strong>Cidade</strong><br/>
    <input type="text" name="cidade" value="Foz do Iguacu" /><br/><br/>
    
    <strong>Estado</strong><br/>
    <input type="text" name="estado" value="PR" /><br/><br/>
    
    
    <input type="hidden" name="total" value="<?php echo $total; ?>" />
    
    <input type="submit" value="Efetuar Compra" class="bottom efetuarCompra" />
    
    
</form>
    
    
    


