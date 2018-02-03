$(function(){
    
    
    $('.efetuarCompra').on('click', function(){
        
        var id = PagSeguroDirectPayment.getSenderHash();
        
        var name = $('input[name=name]').val();
        var cpf = $('input[name=cpf]').val();
        var email = $('input[name=email]').val();
        var pass = $('input[name=password]').val();
        var cep = $('input[name=cep]').val();
        var rua = $('input[name=rua]').val();
        var numero = $('input[name=numero]').val();
        var complemento = $('input[name=complemento]').val();
        var bairro = $('input[name=bairro]').val();
        var cidade = $('input[name=cidade]').val();
        var estado = $('input[name=estado]').val();
        var cartao_titular = $('input[name=cartao_titular]').val();
        var cartao_cpf = $('input[name=cartao_cpf]').val();
        
        var cartao_numero = $('input[name=cartao_numero]').val();
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
                   * finalizar o pagamento usando ajax
                   */
                  
                  $.ajax({
                      url:BASE_URL+'psckttransparente/checkout',
                      type:'POST',
                      data:{
                          id:id, 
                         name:name, 
                         cpf:cpf, 
                         email:email, 
                         pass:pass, 
                         cep:cep, 
                         rua:rua, 
                         numero:numero, 
                         complemento:complemento, 
                         bairro:bairro, 
                         cidade:cidade, 
                         estado:estado, 
                         cartao_titular:cartao_titular, 
                         cartao_cpf:cartao_cpf, 
                         cartao_numero:cartao_numero, 
                         cvv:cvv, 
                         v_mes:v_mes, 
                         v_ano:v_ano,
                         cartao_token:window.cardToken
                      },
                      dataType:'json',
                      success:function(json){
                         if(json.error == true){
                             alert(json.msg);
                         }
                      },
                      error:function(){
                          
                      }
                  });
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
