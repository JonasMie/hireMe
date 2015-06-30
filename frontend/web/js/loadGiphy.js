

$(document).ready(function(){

 jQuery.get("http://api.giphy.com/v1/gifs/search?q=sorry&api_key=dc6zaTOxFJmzC",function (res) {
  	var result = res.data;
  	var rand = Math.floor((Math.random() * 25));
  	var image = result[rand].images;
  	var gif = image.original;
  	var url = gif.url;
  	console.log(url);
  	$("#giphy").attr("src",url);
  	$("#giphy").attr("width",gif.width);
  	$("#giphy").attr("height",gif.height);

    $("#giphyFav").attr("src",url);
    $("#giphyFav").attr("width",gif.width);
    $("#giphyFav").attr("height",gif.height);
    
  });	

});
