@extends('layout.Navbar')
@section('user')
    {{Session::get('UserLogin')->user_Name}}
    {{Session::get('UserLogin')->user_Surname}}
@endsection
@section('script')
<script>
    $( document ).ready(function() {
        $.ajax({
        type: "get",
        url: "NotiRequest",
        cache    : false,
        success:function(data){
            document.getElementById("allNoti").innerHTML = "" ;
            var nowDate ;
            for(i=data.noti.length-1; i>=0 ;i--){
                d = new Date(data.noti[i].created_at);
                var months = ["January", "February", "March", "April", "May", "June", "July","August","September","October","November","December"];
                var days = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
                var stringDate = days[d.getDay()]+", "+d.getDate()+" "+months[d.getMonth()]+" "+(1900+d.getYear());
                if(stringDate != nowDate){
                    document.getElementById("allNoti").innerHTML += "<b><p>"+days[d.getDay()]+", "+d.getDate()+" "+months[d.getMonth()]+" "+(1900+d.getYear())+"</p></b>";
                    nowDate = stringDate ;
                }
                if(data.noti[i].status == "unread"){
                    document.getElementById("allNoti").innerHTML += "<a class='dropdown-item disable unread' onclick=changeNotiStatus('"+data.noti[i].notification_Id+"') href='http://test.dfms.cf"+data.noti[i].link+"'>"+data.noti[i].detail+"</a>"
                } else {
                    document.getElementById("allNoti").innerHTML += "<a class='dropdown-item disable' href='http://test.dfms.cf"+data.noti[i].link+"'>"+data.noti[i].detail+"</a>"
                }
            }
        }
        });
    });
</script>
@endsection
@section('content')
<div class="container content">
    <div class="row">
        <div class="col-12 col-sm-5 col-md-5 col-lg-6 d-none d-sm-block">   
            <p class="topic">Your Notification</p>
        </div>
        <div class="col-12 d-sm-none center">   
            <p class="topic">Your Notification</p>
        </div>
    </div>
    <div id="allNoti">
    </div>
</div>
@endsection