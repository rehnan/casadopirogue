function clear_form() {
                // Limpa valores do formulário de cep.
                $("#street").val("");
                $("#neighborhood").val("");
                $("#city").val("");
                $("#uf").val("");
            }

            //Quando o campo cep perde o foco.
            $("#zip_code").blur(function() {

                $(".error").empty();
                //Nova variável "cep" somente com dígitos.
                var cep = $(this).val().replace(/\D/g, '');

                //Verifica se campo cep possui valor informado.
                if (cep != "") {

                    //Expressão regular para validar o CEP.
                    var validacep = /^[0-9]{8}$/;

                    //Valida o formato do CEP.
                    if(validacep.test(cep)) {

                        //Preenche os campos com "..." enquanto consulta webservice.
                        $("#street").val("Carregando");
                        $("#neighborhood").val("Carregando");
                        $("#city").val("Carregando");
                        $("#uf").val("Carregando");

                        //Consulta o webservice viacep.com.br/
                        $.getJSON("//viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {

                            if (!("erro" in dados)) {
                                //Atualiza os campos com os valores da consulta.
                                $("#street").val(dados.logradouro);
                                $("#neighborhood").val(dados.bairro);
                                $("#city").val(dados.localidade);
                                $("#uf").val(dados.uf);
                            } //end if.
                            else {
                                //CEP pesquisado não foi encontrado.
                                clear_form();
                                $(".error").append('CEP não encontrado!');
                            }
                        });
                    } //end if.
                    else {
                        //cep é inválido.
                        clear_form();
                        $(".error").append('Formato de CEP inválido.');
                    }
                } //end if.
                else {
                    //cep sem valor, limpa formulário.
                    clear_form();
                }
            });
