@extends('layouts.newApp')

@section('styles')

<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/profile.css') }}">
<style type="text/css">
    .overlay{
        width:100vw;
        height:100vh;
        position: fixed;
        top:0;
        left: 0;
        z-index: 1;
        background:#000;
        opacity:.8;
    }
    .modal-close{
        position: fixed;
        right:15px;
        top:-10px;
        font-weight:bold;
        font-size:45px;
        color:#eee;
        cursor:pointer;
        z-index:2;
    }
    .modal-close:hover{color:#fff}
    .details-change{
        display: none;
    }
    .change-btn{
        z-index:2;
        position:fixed;
        bottom:3%;
        text-align:center;
        width:100%;
    }
    .img-change{
        max-width:100vw;
        height: 80vh;
        position:fixed;
        top:5%;
        z-index:2;
        display:none;
    }
    .edit-profile{
        padding: 10px 40px;
        background: green;
        position: absolute;
        right: 0px;
        bottom: -32px;
        border-radius: 0 0 5px 10px;
        -webkit-filter:none !important;
        color:#fff;
        font-weight:bold;
    }
    .profile-avatar img{
        /*width:100%;*/
        height:100%;
    }
    .online, .offline, .me {
      margin-right: 3px;
      font-size: 10px;
    }

    .online {
      color: #86BB71;
    }

    .offline {
      color: #f36948;
    }
    .fa-circle{
    position:relative;
    left:220px;
    top:-42px;
  }
</style>
@endsection

@section('content')



    <div class="profile-card">
        <div class="profile-cover" style="background:grey; background-image: url(@if( !is_null($user->cover_img) ) {{ URL::asset('images/cover_images') }}/{{$user->id}}/{{$user->cover_img}} @else {{ URL::asset('images/cover_images/no-background-picture.jpg') }} @endif);background-repeat:no-repeat;background-size:cover;">
            
            <div class="profile-avatar">
                <div class="btns-container">
                    <div class="profile-links">
                        <a class="zoom-avatar" href="#"><img src="@if( !is_null($user->img) ) {{ URL::asset('images/profile_images') }}/{{$user->id}}/{{$user->img}} @else {{ URL::asset('images/profile_images/no-profile-picture.jpg') }} @endif"></a>
                    </div>
                </div>
                <a href="#"><img src="@if( !is_null($user->img) ) {{ URL::asset('images/profile_images') }}/{{$user->id}}/{{$user->img}} @else {{ URL::asset('images/profile_images/no-profile-picture.jpg') }} @endif" alt="{{$user->name}}" /></a>
            </div>
            <div class="profile-details">
                <h1>{{$user->name}}</h1>
                <h6>
                    <onlinestatus v-bind:onlineusers="onlineUsers" v-bind:userid="{{$user->id}}"></onlinestatus>
                </h6>
                <h6>{{$user->email}}</h6>
                <h6>{{$user->birth_date}}</h6>
            </div>

            @if($is_auth)
                <a href="{{url('edit_profile')}}" class="edit-profile">Edit Profile</a>
            @endif
        </div>
        @if(!$is_auth)
            <div class="text-center" style="margin-top: 10px">
                <a href="{{url('chat/user')}}/{{$user->id}}" class="btn btn-success">Send a Message</a>

                @if( !empty( Auth::user()->friends()->find($user->id) ) )
                    <button class="added btn btn-info btn-xs" disabled>Friends</button>
                @elseif( !empty(Auth::user()->sentRequests->where('receiver',$user->id)->first() ) )
                    <button class="add-{{$user->id}} added btn btn-info btn-xs" disabled onclick="">Friend Request Sent</button> 
                @elseif( !empty( Auth::user()->receivedRequests->find($user->id) ) )
                    <button class="except-{{$user->id}} btn btn-info btn-xs" onclick="except_friend({{$user->id}})">Confirm</button> 
                @else
                    <button class="add-{{$user->id}} btn btn-info btn-xs" onclick="add_friend({{$user->id}})">Add Friend</button> 
                @endif
            </div>
        @endif
    </div>

@endsection

@section('scripts')

<!-- <script type="text/javascript" src="{{ URL::asset('js/friends.js') }}"></script> -->
<script type="text/javascript">
function add_friend(user_id) {

    var btn = $('.add-'+user_id);
    if (btn.is('.added')) {
        return 0;
    }
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: "{{url('add_friend')}}",
        type: 'POST',
        data:{'user_id':user_id},
        success: function (response) {
            if(response == 1){
                btn.html('Friend Request Sent');
                btn.addClass('added');
                btn.prop('disabled', true);
            }
            else{
                alert("sorry some error occured and friend request wasn't sent");
            }
            
        }
    });
}

function remove_friend(user_id){

    var btn = $('.remove-'+user_id);
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: "{{url('remove_friend')}}",
        type: 'POST',
        data:{'user_id':user_id},
        success: function (response) {
            if(response == 1){
                btn.removeClass('remove-'+user_id);
                btn.removeClass('btn-danger');
                btn.addClass('btn-success');
                btn.addClass('add-'+user_id);
                btn.attr('onclick', 'add_friend('+user_id+')');
                btn.html('Add Friend');
            }
            else{
                alert("sorry some error occured and friend wasn't sent");
            }
            
        }
    });

}

function except_friend(user_id){
    var btn = $('.except-'+user_id);
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: "{{url('except_friend')}}",
        type: 'POST',
        data:{'user_id':user_id},
        success: function (response) {
            if(response == 1){
                alert("Friend Request has been Excepted");
                btn.remove();
            }
            else{
                alert("sorry some error occured and friend request wasn't Excepted");
            }
            
        }
    });
}

function closez() {
    $('.overlay').hide();
}
</script>

<script type="text/javascript">
	        $(document).ready(function(){
            $('.profile-card').mouseleave(function(){
                $('.profile-actions').slideUp('fast');
                $('.profile-info').slideUp('fast');
                $('.profile-map').slideUp('fast');
            });

            $('.profile-avatar').hover(
                function(){
                    $('.profile-links').fadeIn('fast');
                },
                function(){
                    $('.profile-links').hide();
                }
            );
            $('.read-more').click(function(){
                $('.profile-map').slideUp('fast');
                $('.profile-info').slideToggle('fast');
                return false;
            });
            $('.view-map').click(function(){
                $('.profile-info').slideUp('fast');
                $('.profile-map').slideToggle('fast');
                return false;
            });
        });
</script>

@if($is_auth)
<script type="text/javascript">
img= document.getElementsByClassName('img-change')[0];
pageWidth = window.innerWidth;
imgWidth = img.offsetWidth;
img.style.left = ( pageWidth - imgWidth ) / 2 + "px";

</script>
@endif

@endsection