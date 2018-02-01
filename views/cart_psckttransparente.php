<h1>Checkout transparente pagseguro</h1>

<form>
    <h3>Dados pessoais</h3>
    
    <strong>Nome:</strong><br/>
    <input type="text" name="name" value="Silvio Coelho" /><br/><br/>
    
    <strong>CPF</strong><br/>
    <input type="text" name="cpf" value="05347965401" /><br/><br/>
    
    <strong>E-mail</strong><br/>
    <input type="email" name="email" value="c23364293093735324206@sandbox.pagseguro.com.br" /><br/><br/>
    
    <strong>Senha</strong><br/>
    <input type="password" name="password" value="CnFj17h2ygu2nXdM" /><br/><br/>
    
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
    
    <h3>Informacoes de pagamento</h3>
    
    <strong>Numero do Cartao</strong><br/>
    <input type="text" name="cartao_numero" value=""/><br/><br/>
    
    <strong>Codigo de Seguranca</strong><br/>
    <input type="text" name="cartao_cvv" value="123"/><br/><br/>
    
    <strong>Validade</strong><br/>
    <select name="cartao_mes">
        <?php for($q=1;$q<=12;$q++): ?>
        <option><?php echo ($q<10)?'0'.$q:$q; ?></option>
        <?php endfor; ?>
    </select>
    
    <select name="cartao_ano">
        <?php $ano = intval(date('Y'));?>
        <?php for($q=$ano;$q<=$ano+20;$q++): ?>
        <option><?php echo $q; ?></option>
        <?php endfor; ?>
    </select><br/><br/>
    
    <button class="button">Efetuar Compra</button>
    
    
    
</form>

<script type="text/javascript" src="https://stc.sandbox.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js"></script>
<script type="text/javascript" src="<?php echo BASE_URL;?>assets/js/psckttransparente.js"></script>
<script type="text/javascript">
PagSeguroDirectPayment.setSessionId("<?php echo $sessionCode;?>");
</script>