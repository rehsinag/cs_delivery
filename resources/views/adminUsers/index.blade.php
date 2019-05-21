@extends('layouts.app')


@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">
            Пользователи
            @include('layouts.preloader')
        </h1>
    </div>
    <div class="adminUsers"></div>

    <div class="modal fade" tabindex="-1" role="dialog" id="adminUserModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        Пользователь
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
        var AdminUsers = {
            opts: {
            },

            list: function () {
                $.ajax({
                    url: '{{ route2('adminUsers.list') }}',
                    data: AdminUsers.opts,
                    beforeSend: function(){csDeliveryPreloader('show')},
                    complete: function(){csDeliveryPreloader('hide')},
                    success: function(data){
                        $('.adminUsers').html(data)
                    },
                    error: function(){
                        csDeliveryNotify(
                            'Возникла ошибка на сервере.. Пожалуйста, попробуйте позднее',
                            'danger'
                        );
                    }
                })
            },

            edit: function(adminUserId){
                if(typeof adminUserId=='undefined')
                    adminUserId=''
                $.ajax({
                    url: "{{ route2('adminUsers.edit') }}",
                    type: 'get',
                    data: 'adminUserId='+adminUserId,
                    beforeSend: function(){csDeliveryPreloader('show')},
                    complete: function(){csDeliveryPreloader('hide')},
                    success: function(resp){
                        $('#adminUserModal .modal-body').html(resp)
                        $("#adminUserModal").modal()
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
                    url: "{{ route2('adminUsers.submit') }}",
                    type: 'post',
                    data: $('#adminUserModalForm').serialize(),
                    beforeSend: function(){csDeliveryPreloader('show')},
                    complete: function(){csDeliveryPreloader('hide')},
                    success: function(resp){
                        if(resp.success) {
                            $("#adminUserModal").modal('hide');
                            AdminUsers.list();
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

            delete: function (adminUserId) {
                if(!(confirm('Удалить отмеченную запись?'))) {
                    return false;
                }
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "{{ route2('adminUsers.delete') }}",
                    type: 'post',
                    data: 'adminUserId='+adminUserId,
                    beforeSend: function(){csDeliveryPreloader('show')},
                    complete: function(){csDeliveryPreloader('hide')},
                    success: function(resp){
                        if(resp.success) {
                            AdminUsers.list();
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
            AdminUsers.list();
        })
    </script>
@endsection