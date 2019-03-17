@extends('layouts.app')


@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">
            Курьеры
            @include('layouts.preloader')
        </h1>
    </div>
    <div class="deliveryUsers"></div>

    <div class="modal fade" tabindex="-1" role="dialog" id="deliveryUserModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        Курьер
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    sdf
                </div>

            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
@endsection


@section('scripts')
    <script>
        var DeliveryUsers = {
            opts: {
                'actual': 1
            },

            list: function () {
                $.ajax({
                    url: '{{ route('deliveryUsers.list') }}',
                    data: DeliveryUsers.opts,
                    beforeSend: function(){csDeliveryPreloader('show')},
                    complete: function(){csDeliveryPreloader('hide')},
                    success: function(data){
                        $('.deliveryUsers').html(data)
                    },
                    error: function(){
                        csDeliveryNotify(
                            'Возникла ошибка на сервере.. Пожалуйста, попробуйте позднее',
                            'danger'
                        );
                    }
                })
            },

            edit: function(deliveryUserId){
                if(typeof deliveryUserId=='undefined')
                    deliveryUserId=''
                $.ajax({
                    url: "{{ route('deliveryUsers.edit') }}",
                    type: 'get',
                    data: 'deliveryUserId='+deliveryUserId,
                    beforeSend: function(){csDeliveryPreloader('show')},
                    complete: function(){csDeliveryPreloader('hide')},
                    success: function(resp){
                        $('#deliveryUserModal .modal-body').html(resp)
                        $("#deliveryUserModal").modal()
                    },
                    error: function(){
                        csDeliveryNotify(
                            'Возникла ошибка на сервере.. Пожалуйста, попробуйте позднее',
                            'danger'
                        );
                    }
                });
            },

            submit: function () {
                $.ajax({
                    url: "{{ route('deliveryUsers.submit') }}",
                    type: 'post',
                    data: $('#deliveryUserModalForm').serialize(),
                    beforeSend: function(){csDeliveryPreloader('show')},
                    complete: function(){csDeliveryPreloader('hide')},
                    success: function(resp){
                        if(resp.success) {
                            $("#deliveryUserModal").modal('hide');
                            DeliveryUsers.list();
                            csDeliveryNotify(resp.message, 'success');
                        } else {
                            $.notify({
                                // options
                                message: resp.message
                            },{
                                // settings
                                type: 'danger',
                                z_index: 2000,
                            });
                        }
                    },
                    error: function(){
                        csDeliveryNotify(
                            'Возникла ошибка на сервере.. Пожалуйста, попробуйте позднее',
                            'danger'
                        );
                    }
                });
            },

            delete: function (deliveryUserId) {
                if(!(confirm('Удалить отмеченную запись?'))) {
                    return false;
                }
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "{{ route('deliveryUsers.delete') }}",
                    type: 'post',
                    data: 'deliveryUserId='+deliveryUserId,
                    beforeSend: function(){csDeliveryPreloader('show')},
                    complete: function(){csDeliveryPreloader('hide')},
                    success: function(resp){
                        if(resp.success) {
                            DeliveryUsers.list();
                            csDeliveryNotify(resp.message, 'success');
                        } else {
                            csDeliveryNotify(resp.message, 'danger');
                        }
                    },
                    error: function(){
                        csDeliveryNotify(
                            'Возникла ошибка на сервере.. Пожалуйста, попробуйте позднее',
                            'danger'
                        );
                    }
                });
            },
        }
        $(document).ready(function () {
            DeliveryUsers.list();
        })
    </script>
@endsection