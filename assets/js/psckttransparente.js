$(function(){
    $('input[name=cartao_numero]').on('keyup', function(e){
        if($(this).val().length == 6){
            PagSeguroDirectPayment.getBrand({
               cardBin: $(this).val(),
               success:function(r){
                   window.cardBrand = r.brand.name;
                   var cvvLimit = r.brand.cvvSize;
                   
                   $('input[name=cartao_cvv]').attr('maxlength', cvvLimit);
                   
               },
               error:function(r){
                   
               },
               complete:function(r){}
            });
        }
    });
});
