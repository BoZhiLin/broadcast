@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="{{ mix('js/app.js') }}"></script>
<script>
    const token = "{{ $token }}";
    Echo.channel(`laravel_database_user_${token}`)
        .listen('PushNotification', e => {
            swal({
                title: "您的帳戶已於其他裝置登入！",
                text: "按下確認後將為您導向登入頁面",
                showConfirmButton: true
            }, function (isConfirm) {
                if (isConfirm) {
                    window.location.reload()
                }
            });
        });

</script>
@endsection
