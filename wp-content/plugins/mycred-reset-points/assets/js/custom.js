jQuery("#reset_points" ).on( "click", function(event) {
	event.preventDefault();
	var userID = jQuery('#reset_points').attr('data-user');
	var roleCheck = jQuery('#reset_points').attr('data-role');
	var roles = [];
	var pointtypes = [];
		if (roleCheck) {
			roles = getUserRoles();
		}

		pointtypes = getPointtypes();

		if (parseInt(roleCheck) == 1 && (pointtypes.length === 0 || roles.length === 0)) {
				alert('Please select role and point type.');return;
		}

		if (parseInt(roleCheck) == 0 && pointtypes.length == 0) {
			alert('Please select point type.'); return;
		}
		 
		var data = {
			'action': 'reset_points',
			'userID':userID,
			'roles':roles,
			'pointtypes':pointtypes,
			'roleCheck':roleCheck
		};

		// since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
		jQuery.post(ajaxurl, data, function(response) {
			alert('Points and logs have been reset successfully.');
			location.reload(true);
		});
});

function getPointtypes(){
	var pointTypes = [];
   	jQuery.each(jQuery("input[name='pointtypes']:checked"), function(){            
                pointTypes.push(jQuery(this).val());
    });

   	return pointTypes;
}


function getUserRoles(){
	var userRoles = [];
   	jQuery.each(jQuery("input[name='roles']:checked"), function(){            
                userRoles.push(jQuery(this).val());
    });

   	return userRoles;
}