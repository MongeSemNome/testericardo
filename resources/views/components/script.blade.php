    <script>

    $(document).ready(function(){
        $(document).on('submit','form[class^="method-"]',function(e){
            e.preventDefault();
            e.stopPropagation();
            e.stopImmediatePropagation();

            $form = $(this);

            ajax_options = {};

            if($form.find('input[type="file"]').length > 0){
                ajax_options.data = new FormData($form[0]);
                ajax_options.processData = false;
                ajax_options.contentType = false;
            }else{
                ajax_options.data = JSON.stringify($form.serializeArray().reduce(function(obj, item) {
                    obj[item.name] = item.value;
                    return obj;
                }, {}));
                ajax_options.contentType = 'application/json';
            }
            ajax_options.type = ($form.attr('class').split(' ').find(function(cls) {
                return cls.startsWith('method-');
            }) || 'method-post').replace('method-', '').toUpperCase();

            $.ajax({
                ...ajax_options,
                url: $form.attr('action'),
                dataType: 'json',
                beforeSend: function(request) {
                    $form.find('button[type="submit"]').prop('disabled', true).html(
                        $('<span>')
                            .addClass('spinner-border spinner-border-sm')
                            .attr('role', 'status')
                            .attr('aria-hidden', true)
                    ).prepend('Enviando...');
                    if ('bearer' in xData) {
                        request.setRequestHeader('Authorization', 'Bearer ' + xData.bearer);
                    }
                },
                statusCode: {

                    201: function(response) {
                        $form.find('button[type="submit"]').prop('disabled', false).html('Enviar outro');
                    },
                    202: function(response) {
                        Swal.fire('Sucesso!', 'A solicitação foi aceita e está sendo processada.', 'Success');
                    },
                    204: function(response, textStatus, jqXHR) {
                        Swal.fire('Sucesso!', 'Operação realizada com sucesso.', 'Success');
                    },
                    300: function(response) {
                        Swal.fire('Múltiplas escolhas', 'Existem múltiplas opções para este registro.', 'info');
                    },
                    301: function(response) {
                        Swal.fire('Movido permanentemente', 'O registro foi movido para outro local.', 'info');
                    },
                    302: function(response) {
                        Swal.fire('Redirecionado', 'O registro foi encontrado em outro local.', 'info');
                    },
                    307: function(response) {
                        Swal.fire('Redirecionamento temporário', 'O registro foi movido temporariamente.', 'info');
                    },
                    308: function(response) {
                        Swal.fire('Redirecionamento permanente', 'O registro foi movido permanentemente.', 'info');
                    },
                    400: function(response) {
                        Swal.fire('Problema com dados', 'Problema com formaçãode de dados entre em contato conosco.', 'error');
                    },
                    401: function(response) {
                        Swal.fire('Erro!', 'Você foi desconectado.', 'error').then(() => {
                            window.location.reload();
                        });
                    },

                    403: function(response) {
                        Swal.fire('Acesso negado!', 'Você não tem permissão para realizar esta ação.', 'warning');
                    },
                    404: function(response) {
                        Swal.fire('Não encontrado!', 'O registro solicitado não foi encontrado.', 'error');
                    },
                    405: function(response) {
                        Swal.fire('Método não permitido!', 'O método da requisição não é permitido.', 'error');
                    },
                    408: function(response) {
                        Swal.fire('Tempo expirado!', 'O tempo da requisição expirou.', 'error');
                    },
                    409: function(response) {
                        Swal.fire('Conflito!', 'Já existe uma chamada em andamento.', 'error');
                    },
                    422: function(response) {
                        if (response.responseJSON.errors !== undefined) {
                              $form.validate().resetForm();
                              $.each(response.responseJSON.errors, function(input, messages) {
                                  var input = $form.find('[name="' + input + '"]');
                                  var errorMessages = '';

                                  $.each(messages, function(input, message) {
                                      errorMessages += message + '<br>';
                                  });

                                  $form.validate().showErrors({
                                      [input]: errorMessages
                                  });

                                });
                            }
                            $form.find('button[type="submit"]').prop('disabled', false).html('Enviar novamente');
                        }
                    },
                    423: function(response) {
                        Swal.fire('Bloqueado!', 'Você perdeu acesso a este recurso. Entre em contato conosco.', 'error');
                    },
                    428: function(response) {
                        Swal.fire('Pré-condição necessária!', 'A requisição requer uma condição específica que não foi atendida.', 'error');
                    },
                    429: function(response) {
                        Swal.fire('Muitas requisições!', 'Você fez muitas requisições em um curto período. Tente novamente mais tarde.', 'warning');
                    },
                    500: function(response) {
                        Swal.fire('Erro no servidor!', 'Ocorreu um erro interno no servidor.', 'error');
                    },
                    502: function(response) {
                        Swal.fire('Bad Gateway!', 'Resposta inválida do servidor.', 'error');
                    },
                    503: function(response) {
                        Swal.fire('Serviço indisponível!', 'O servidor está temporariamente indisponível.', 'error');
                    },
                    504: function(response) {
                        Swal.fire('Timeout!', 'O tempo de resposta do servidor expirou.', 'error');
                    },
                    422: function(response) {
                        if (response.responseJSON.errors !== undefined) {
                            $form.validate().resetForm();
                            $.each(response.responseJSON.errors, function(input, messages) {
                                var input = $form.find('[name="' + input + '"]');
                                var errorMessages = '';

                                $.each(messages, function(input, message) {
                                    errorMessages += message + '<br>';
                                });

                                $form.validate().showErrors({
                                    [input]: errorMessages
                                });
                            });
                        }
                        $form.find('button[type="submit"]').prop('disabled', false).html('Enviar novamente');
                    }
                });
            });
        });
    </script>
