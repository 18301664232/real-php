$(function(){
	//上传的图片转成base64位码
	$('.upload-file').change(function(e){
		var file = e.target.files[0];
		var fileReader = new FileReader();
		fileReader.readAsDataURL(file);
		fileReader.onload = function(){
			$('img').attr('src',fileReader.result);
		}
	})
});




