jQuery(document).ready(function()
{

	$('.element_formularza').one('keyup', function() {
			$(this).parent().parent().append('<span class="limit"></span>')
		}).keyup(function() {
		var limitznakow = $(this).attr('limitznakow');
		if ( limitznakow != null)
		{
			var dlugosc = $(this).val().length;
			var dlugosc = limitznakow-dlugosc;
			$(this).parent().parent().find('span.limit').text(-dlugosc);
		};
	});

	$('#zalaczniki_pole_formularza').parent().mouseenter(function() {
		$(this).find('span.limit').hide();
	}).mouseleave(function() {
		$(this).find('span.limit').show();
	});

	CKEDITOR.replace( 'tresc_wiadomosci_pole_formularza', {
		height : 100,
		resize_maxHeight : 400,
		language : wyciagnietyJezyk,
//		uiColor : '#9AB8F3',
		toolbar : 'Basic',
		toolbar : [
			{ name: 'basicstyles', items: [ 'Bold', 'Italic', 'Strike', '-', 'RemoveFormat' ] },
			{ name: 'links', items: [ 'Link', 'Unlink' ] },
			{ name: 'insert', items: [ 'Image', 'Table', 'HorizontalRule' ] },
			{ name: 'paragraph', items: [ 'NumberedList', 'BulletedList', '-', 'Blockquote' ] },
			{ name: 'tools', items: [ 'Maximize' ] },
		],
		extraPlugins: 'wordcount',
		wordcount: {
			// Whether or not you want to show the Paragraphs Count
			showParagraphs: true,
		
			// Whether or not you want to show the Word Count
			showWordCount: true,
		
			// Whether or not you want to show the Char Count
			showCharCount: true,
		
			// Whether or not you want to count Spaces as Chars
			countSpacesAsChars: true,
		
			// Whether or not to include Html chars in the Char Count
			countHTML: true,
			
			// Maximum allowed Word Count, -1 is default for unlimited
			maxWordCount: -1,
		
			// Maximum allowed Char Count, -1 is default for unlimited
			maxCharCount: $('#tresc_wiadomosci_pole_formularza').attr('limitznakow')-25,
		}
	   }).on('instanceReady', function() {
		$('#tresc_wiadomosci_pole_formularza').parent().find('label').remove();
	   });

});