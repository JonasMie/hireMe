angular.module('starter.controllers', [])

.controller('AppCtrl', function($scope, $ionicModal, $timeout) {


  


})

.controller('HomeCtrl', function($scope,$http,$compile,$ionicPlatform) {

	var markers = [];

	 var myLatlng = new google.maps.LatLng(48.77584600,9.18293200);
 
        var mapOptions = {
            center: myLatlng,
            zoom: 12,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };
 
        var map = new google.maps.Map(document.getElementById("map"), mapOptions);
 
        navigator.geolocation.getCurrentPosition(function(pos) {
            map.setCenter(new google.maps.LatLng(pos.coords.latitude, pos.coords.longitude));
            var myLocation = new google.maps.Marker({
                position: new google.maps.LatLng(pos.coords.latitude, pos.coords.longitude),
                map: map,
                animation: google.maps.Animation.DROP,
                title: "My Location"
            });

            var contentString = "<div><h5>Meine Position</h5></div>";
        	var compiled = $compile(contentString)($scope);
	        var infowindow = new google.maps.InfoWindow({
	           content: compiled[0]
	         });
             google.maps.event.addListener(myLocation, 'click', function() {
          	 infowindow.open(map,myLocation);
         	});
        });

$ionicPlatform.ready(function() {

	 $http.get('http://frontend/mobile/')

 		.success(function(data, status, headers, config) {
 
       		console.log(data);

       		if (status == 200) {
       		for (var i = 0; i < data.length; i++) {

       			var job = data[i];
       			var contentString = "<div><h5>"+job.title+"</h5></div>";
                var compiled = $compile(contentString)($scope);
  				var infowindow = new google.maps.InfoWindow({
                    content: compiled[0]
                 });
                        
       			var jobPosition = new google.maps.Marker({
                position: new google.maps.LatLng(job.latitude,job.longitude),
                map: map,
                animation: google.maps.Animation.DROP,
                title: "My Location",
                html:compiled[0]
            	});
       			markers.push(jobPosition);

       			}
       		}

       		for (var i = 0; i < markers.length; i++) {

         	 var marker = markers[i];
             google.maps.event.addListener(marker, 'click', function () {
                 infowindow.setContent(this.html);
                 infowindow.open(map, this);
         	 });
       		 
       		 }

       		 $scope.map = map;
       });

  });


	 function loadMarkers() {

          for (var i = 0; i < markers.length; i++) {
          var marker = markers[i];
             google.maps.event.addListener(marker, 'click', function () {
                 // where I have added .tml to the marker object.
                 infowindow.setContent(this.html);
                 infowindow.open(map, this);
          });
        }

     }

})

.controller('ListCtrl', function($scope) {
  

  
})

.controller('EventCtrl', function($scope) {
  

  
})

.controller('MessageCtrl', function($scope) {
  

  
})

.controller('SettingsCtrl', function($scope) {
  

  
})

.controller('PlaylistCtrl', function($scope, $stateParams) {
});
