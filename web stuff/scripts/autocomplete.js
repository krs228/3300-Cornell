jQuery(document).ready(function($){
	$('#courseSearch').autocomplete({source:'autoComplete.php', minLength:2});
});