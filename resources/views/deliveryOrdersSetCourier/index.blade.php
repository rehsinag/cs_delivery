@extends('layouts.app')


@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">
            Заявки в статусе Досье принято
            @include('layouts.preloader')
        </h1>
    </div>
    <div class="deliveryOrders"></div>

    <div class="modal fade" tabindex="-1" role="dialog" id="deliveryOrderModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        Заявка
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
        var DeliveryOrders = {
            opts: {
                'actual': 1
            },

            list: function () {
                $.ajax({
                    url: '{{ route('deliveryOrders.setCourier.list') }}',
                    data: DeliveryOrders.opts,
                    beforeSend: function(){csDeliveryPreloader('show')},
                    complete: function(){csDeliveryPreloader('hide')},
                    success: function(data){
                        $('.deliveryOrders').html(data)
                    },
                    error: function(){
                        csDeliveryNotify(
                            'Возникла ошибка на сервере.. Пожалуйста, попробуйте позднее',
                            'danger'
                        );
                    }
                })
            },

            edit: function(deliveryOrderId){
                if(typeof deliveryOrderId=='undefined')
                    deliveryOrderId=''
                $.ajax({
                    url: "{{ route('deliveryOrders.setCourier.edit') }}",
                    type: 'get',
                    data: 'deliveryOrderId='+deliveryOrderId,
                    beforeSend: function(){csDeliveryPreloader('show')},
                    complete: function(){csDeliveryPreloader('hide')},
                    success: function(resp){
                        $('#deliveryOrderModal .modal-body').html(resp)
                        $("#deliveryOrderModal").modal()
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
                    url: "{{ route('deliveryOrders.setCourier.submit') }}",
                    type: 'post',
                    data: $('#deliveryOrderModalForm').serialize(),
                    beforeSend: function(){csDeliveryPreloader('show')},
                    complete: function(){csDeliveryPreloader('hide')},
                    success: function(resp){
                        if(resp.success) {
                            $("#deliveryOrderModal").modal('hide');
                            DeliveryOrders.list();
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

        }
        $(document).ready(function () {
            DeliveryOrders.list();
        })
    </script>
@endsection