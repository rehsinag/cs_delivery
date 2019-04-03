@extends('layouts.app')


@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">
            Филиалы
            @include('layouts.preloader')
        </h1>
    </div>
    <div class="branches"></div>

    <div class="modal fade" tabindex="-1" role="dialog" id="branchModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        Филиал
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
        var Branches = {
            opts: {
                'actual': 1
            },

            list: function () {
                $.ajax({
                    url: '{{ route('catalogs.branches.list') }}',
                    data: Branches.opts,
                    beforeSend: function(){csDeliveryPreloader('show')},
                    complete: function(){csDeliveryPreloader('hide')},
                    success: function(data){
                        $('.branches').html(data)
                    },
                    error: function(){
                        csDeliveryNotify(
                            'Возникла ошибка на сервере.. Пожалуйста, попробуйте позднее',
                            'danger'
                        );
                    }
                })
            },

            edit: function(branchId){
                if(typeof branchId=='undefined')
                    branchId=''
                $.ajax({
                    url: "{{ route('catalogs.branches.edit') }}",
                    type: 'get',
                    data: 'branchId='+branchId,
                    beforeSend: function(){csDeliveryPreloader('show')},
                    complete: function(){csDeliveryPreloader('hide')},
                    success: function(resp){
                        $('#branchModal .modal-body').html(resp)
                        $("#branchModal").modal()
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
                    url: "{{ route('catalogs.branches.submit') }}",
                    type: 'post',
                    data: $('#branchModalForm').serialize(),
                    beforeSend: function(){csDeliveryPreloader('show')},
                    complete: function(){csDeliveryPreloader('hide')},
                    success: function(resp){
                        if(resp.success) {
                            $("#branchModal").modal('hide');
                            Branches.list();
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

            delete: function (branchId) {
                if(!(confirm('Удалить отмеченную запись?'))) {
                    return false;
                }
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "{{ route('catalogs.branches.delete') }}",
                    type: 'post',
                    data: 'branchId='+branchId,
                    beforeSend: function(){csDeliveryPreloader('show')},
                    complete: function(){csDeliveryPreloader('hide')},
                    success: function(resp){
                        if(resp.success) {
                            Branches.list();
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
            Branches.list();
        })
    </script>
@endsection