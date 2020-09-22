@extends ('core::layouts.master')
@section ('content')
    <section>
        <div class="notification-status">
            <span class="badge badge-secondary">Please Wait...</span>
        </div>
    </section>
    @include ('core::components.header-box')

    <p>All devices registered below can receive push notification from this CMS</p>

    @if(isset($datatable))
        {!! $datatable->tableView() !!}
    @endif

@stop

@section ('datatable_script')
	@if(isset($datatable))
		{!! $datatable->assets() !!}
	@endif
@stop

@push ('script')
<script src="https://www.gstatic.com/firebasejs/7.16.1/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/7.16.1/firebase-messaging.js"></script>
<script>
    function setNotificationStatus(){
        if(Notification.permission == 'granted'){
            $(".notification-status span").removeClass('badge-secondary badge-danger').addClass('badge-success').html('Notification Enabled');
        }
        else{
            $(".notification-status span").removeClass('badge-secondary badge-success').addClass('badge-danger').html('Notification Disabled');
        }
    }

    function saveTokenToServer(token){
        $.ajax({
            type : 'POST',
            dataType : 'json',
            data : {
                _token : window.CSRF_TOKEN,
                pushtoken : token,
                device_name : navigator.appVersion + ' ' + navigator.appCodeName
            },
            success : function(resp){
                if(typeof resp.type != 'undefined'){
                    toastr['success']('Your device has been registered successfully');
                }
            },
        });
    }

    var config = {
        messagingSenderId: "{{ env('FCM_SENDER_ID') }}",
        apiKey: "{{ env('FCM_API_KEY') }}",
        projectId: "{{ env('FCM_PROJECT_ID') }}",
        appId: "{{ env('FCM_APP_ID') }}"
    };
    firebase.initializeApp(config);


    const messaging = firebase.messaging();
    messaging
        .requestPermission()
        .then(function () {
            setNotificationStatus();
            return messaging.getToken();
        })
        .then((token) => {
            saveTokenToServer(token);
        })
        .catch(function (err) {
            setNotificationStatus();
        });    
</script>
@endpush