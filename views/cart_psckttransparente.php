<h1>Checkout transparente pagseguro</h1>
<script type="text/javascript" src="https://stc.sandbox.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js"></script>
<script type="text/javascript">
PagseguroDirectPayment.setSessionId("<?php echo $sessionCode;?>")
</script>
<?php echo $sessionCode;?>