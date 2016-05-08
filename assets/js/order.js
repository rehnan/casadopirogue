$(document).ready(function (){

   if ($( "#selecao-item" ).length > 0) {
         if ($('#selecao-item').val() != '[Selecione um Produto]') { get_itens(); }
   }

   $('#selecao-item').change(function(){
    if ($('#selecao-item').val() == '[Selecione um Produto]') {
      $('#selecao-sabor-item').val('[Selecione o Sabor]');
      $('#selecao-sabor-item').attr('disabled', 'disabled');
      return false;
   }

   get_itens();

});

   function get_itens() {
     var category = $('#selecao-item').val().toLowerCase();
     var url = 'order/itens/'+category;

     $('#selecao-sabor-item').removeAttr('disabled');
     $.ajax({
      type: 'GET',
      dataType: 'json',
      contentType: "application/json; charset=utf-8",
      url: url,
      success: function(data, status) {
         console.log(data);
         $('#selecao-sabor-item').children().remove();
         $.each(data, function(index, item){
            $("#selecao-sabor-item").append(new Option(item.name, item.id+'|'+item.name));
         });
      },
      error: function(data, status) {
         alert('Erro ao tentar carregar os sabores detsa categoria!!');
      },
   });
  }

/*$("#add-item").click(function(event) {
   var order_id = $('#order_id').text();
   var url = 'order/'+order_id+'/itens';

   $.ajax({
      type: 'POST',
      data: $("#itens-form").serialize(),
      url: url,
      success: function(data, status) {
         console.log(data);
      },
      error: function(data, status) {
         alert('Erro ao tentar salvar um novo item!');
      },
   });
});*/

});