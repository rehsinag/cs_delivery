@extends('layouts.app')


@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">
            Продукты
            @include('layouts.preloader')
        </h1>
    </div>
    <div class="products"></div>

    <div class="modal fade" tabindex="-1" role="dialog" id="productModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        Продукт
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
        var Products = {
            opts: {},

            list: function () {
                $.ajax({
                    url: '{{ route('products.list') }}',
                    data: Products.opts,
                    beforeSend: function(){csDeliveryPreloader('show')},
                    complete: function(){csDeliveryPreloader('hide')},
                    success: function(data){
                        $('.products').html(data)
                    },
                    error: function(){
                        csDeliveryNotify(
                            'Возникла ошибка на сервере.. Пожалуйста, попробуйте позднее',
                            'danger'
                        );
                    }
                })
            },

            edit: function(id){
                if(typeof id=='undefined')
                    id=''
                $.ajax({
                    url: "{{ route('products.edit') }}",
                    // url: "/panel/admin/bunches/editForm?id=" + id,
                    type: 'get',
                    data: 'id='+id,
                    beforeSend: function(){csDeliveryPreloader('show')},
                    complete: function(){csDeliveryPreloader('hide')},
                    success: function(resp){
                        $('#productModal .modal-body').html(resp)
                        $("#productModal").modal()
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
                    url: "{{ route('products.submit') }}",
                    type: 'post',
                    data: $('#productModalForm').serialize(),
                    beforeSend: function(){csDeliveryPreloader('show')},
                    complete: function(){csDeliveryPreloader('hide')},
                    success: function(resp){
                        if(resp.success) {
                            $("#productModal").modal('hide');
                            Products.list();
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
            }
        }
        $(document).ready(function () {
            Products.list();
        })
    </script>
@endsection