

function add_friend(user_id) {

	var btn = $('.add-'+user_id);
	if (btn.is('.added')) {
		return 0;
	}
	$.ajaxSetup({
	    headers: {
	        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
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
	        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
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
	        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
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