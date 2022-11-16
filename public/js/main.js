$(document).ready(function () {
    $('.product-card').on("click", function () {
        $(this).children("a");
        var linkToProduct = $(this).children("a").prop("href");
        window.location = linkToProduct;

    });
    $('#valueRange').text($('#formControlRange').val());
    $('#formControlRange').on("change", function () {
        console.log($(this).val());
        $('#valueRange').text($(this).val());
    })

    $('select[name=slBoLoc]').on("change", function () {
   
        
        console.log($(this).val());
       
        $valueOp = $(this).val();
        $('input[name="boLoc"]').val($valueOp);
      
        $('#btnLSearch').trigger("click");
		
    })
    

    var ipSoLuong = $('input[name="nbSoLuong"]');
    
    $('#plus').on("click", function(){
        var number = parseInt(ipSoLuong.val());
        number += 1;
        if(number <= 100){
            ipSoLuong.val(number);
        }
    
    })
    $('#minus').on("click", function(){
        var number = ipSoLuong.val();
        number -= 1;
        if(number > 0){
            ipSoLuong.val(number);
        }
        
    })

   
})