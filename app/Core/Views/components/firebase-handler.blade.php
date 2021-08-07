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
            url : '{{ route('admin.push-notif.register') }}',
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
        messagingSenderId: "{{ config('cms.config.fcm_sender_id') }}",
        apiKey: "{{ config('cms.config.fcm_api_key') }}",
        projectId: "{{ config('cms.config.fcm_project_id') }}",
        appId: "{{ config('cms.config.fcm_app_id') }}"
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