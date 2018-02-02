$(function(){
    
    
    $('.efetuarCompra').on('click', function(){
        var numero = $('input[name=cartao_numero]').val();
        var cvv = $('input[name=cartao_cvv]').val();
        var v_mes = $('select[name=cartao_mes]').val();
        var v_ano = $('select[name=cartao_ano]').val();
        
        if(numero != '' && cvv != '' && v_mes != '' && v_ano != ''){
           PagSeguroDirectPayment.createCardToken({
               cardNumber:numero,
               brand:window.cardBrand,
               cvv:cvv,
               expirationMonth:v_mes,
               expirationYear:v_ano,
               success:function(r){
                  window.cardToken = r.card.token; 
                  
                  /*
                   * finalizar o pagamento
                   */
               },
               error:function(r){
                   
               },
               complete:function(r){
                   
               }
           }); 
        } else {
            alert('aaaaaaaaaaaaa');
        }
    });
    
    
    
    
    $('input[name=cartao_numero]').on('keyup', function(e){
        if($(this).val().length == 6){
            PagSeguroDirectPayment.getBrand({
               cardBin: $(this).val(),
               success:function(r){
                   window.cardBrand = r.brand.name;
                   var cvvLimit = r.brand.cvvSize;
                   
                   $('input[name=cartao_cvv]').attr('maxlength', cvvLimit);
                   
                   PagSeguroDirectPayment.getInstallments({
                       amount:100,
                       brand:window.cardBrand,
                       maxInstallmentNoInterest:10,
                       success:function(r){
                           if(r.error == false){
                               var parc = r.installments[window.cardBrand];
                               
                               var html = '';
                               for(var i in parc){
                                   var optionValue = parc[i].quantity+';'+parc[i].installmentAmount+';';
                                   if(parc[i].interestFree == true){
                                       optionValue +='true';
                                       
                                   } else {
                                       optionValue += 'false';
                                   }
                                   html += '<option value="'+optionValue+'">'+parc[i].quantity+' x de R$ '+parc[i].installmentAmount+'</option>';
                               }
                               $('select[name=parc]').html(html);
                           }
                       },
                       error:function(r){
                           
                       },
                       complete:function(r){}
                   });
                   
               },
               error:function(r){
                   
               },
               complete:function(r){}
            });
        }
    });
});
