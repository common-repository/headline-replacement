var hr_settings	= {
	button_text : 'Use as headline'
}

function headline_image_add(attachment_id, thumb_url)
{
	mainFrame = parent.window.document;// get main frame
	mainFrame.getElementById('headline_image_value').value = attachment_id;// add image id to hidden form entry
	mainFrame.getElementById('headline_image_show').innerHTML = '<img class="thumbnail" src="' + thumb_url + '" alt="Unique Image" />\n';// show image
	mainFrame.getElementById('headline_image_remove').style.display = 'block';// show Remove button

	// close window
	var win = window.dialogArguments || opener || parent || top;
	win.tb_remove();

}

function headline_image_clear()
{
	document.getElementById('headline_image_value').value = 0;// no image
	document.getElementById('headline_image_show').innerHTML = '';// hide image
	document.getElementById('headline_image_remove').style.display = 'none';// hide Remove button
}


// generate Insert into headline button
function headline_image_add_button()
{	

	elements = document.getElementById('media-items');

	// Media upload window is opened
	if (elements)
	{
		children = elements.childNodes;

		// create buttons in these elements
		for (var i=0; i < children.length; i++)
		{
			if (children[i].nodeName == 'DIV')
			{
				// id number of object
				pattern_id = /[0-9]+/;
				id = children[i].id.match(pattern_id);

				parent_element = document.getElementById('del_attachment_' + id).parentNode;

				// get thumbnail
				thumb = document.getElementById('thumbnail-head-' + id).childNodes[0].src;

				// create button
				button = document.createElement('input');
				button.setAttribute('type', 'submit');
				button.setAttribute('onclick', 'headline_image_add(' + id + ', \'' + thumb + '\')');
				button.setAttribute('value', hr_settings.button_text);
				button.setAttribute('name', 'headline_image');
				button.setAttribute('class', 'button');

				// insert button after "Insert into Post" button
				parent_element.insertBefore(button, parent_element.childNodes[1]);
			}
		}
	}

	return false;
}
window.onload = headline_image_add_button;// add buttons, if Media upload window is opened

// add buttons on swfupload
jQuery(document).ready(function(){
	jQuery(document).ajaxComplete(function(e, xhr, settings){
		jQuery("input[id^='type-of-']").each(function(){
			if ( settings.url == 'async-upload.php' ) {
				var type = jQuery(this).val();
				if ( type == "image" ) {
					var parts = jQuery(this).attr('id').split('-');
					var id = parts[2];
					var thumb = jQuery('#thumbnail-head-'+id+' img').attr('src');
	
					// create button
					button = document.createElement('input');
					button.setAttribute('type', 'submit');
					button.setAttribute('onclick', 'headline_image_add(' + id + ', \'' + thumb + '\')');
					button.setAttribute('value', hr_settings.button_text);
					button.setAttribute('name', 'headline_image');
					button.setAttribute('id', 'headline_image_'+id);
					button.setAttribute('class', 'button');
					
					// insert button after "Insert into Post" button
					jQuery('.slidetoggle input.button[type=submit]:first').after(button);
				}
			}
		});
	});
});

