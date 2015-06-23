angular.module('starter.controllers', [])

.controller('AppCtrl', function($scope, $ionicModal, $timeout,$http) {


})

.controller('HomeCtrl', function($scope, $ionicLoading, $compile,$http,$ionicSideMenuDelegate) {


		$ionicSideMenuDelegate.canDragContent(false);
		
		var markers= [];
      
        var myLatlng = new google.maps.LatLng(48.775846,9.182932);
 
        var mapOptions = {
            center: myLatlng,
            zoom: 16,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };
 
        var map = new google.maps.Map(document.getElementById("map"), mapOptions);
        var myLocation;

        navigator.geolocation.getCurrentPosition(function(pos) {

        		myLocation = new google.maps.Marker({
                position: new google.maps.LatLng(pos.coords.latitude, pos.coords.longitude),
                map: map,
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

		  
        })
 	
        navigator.geolocation.watchPosition(function(pos) {
        	myLocation.setPosition(new google.maps.LatLng(pos.coords.latitude, pos.coords.longitude));
            map.setCenter(new google.maps.LatLng(pos.coords.latitude, pos.coords.longitude));
   
        });


        

 
      $http.get('http://frontend/mobile/get-jobs')

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


})

.controller('ListCtrl', function($scope,$ionicSideMenuDelegate) {

  		$ionicSideMenuDelegate.canDragContent(true);


  
})

.controller('EventCtrl', function($scope,$ionicSideMenuDelegate) {
    	
    	$ionicSideMenuDelegate.canDragContent(true);


  
})

.controller('MessageCtrl', function($scope,$ionicSideMenuDelegate) {
     	
     	$ionicSideMenuDelegate.canDragContent(true);
 

  
})

.controller('SettingsCtrl', function($scope,$ionicSideMenuDelegate) {
  
    	$ionicSideMenuDelegate.canDragContent(true);

  
})

.controller('AdCtrl', function($scope,$ionicSideMenuDelegate) {

	  var array = [
		{src:"http://bilder.bild.de/fotos/lachsack-36229038/Bild/1.bild.jpg",
		 link:"http://daimler.com"},
		 {src:"https://s-media-cache-ak0.pinimg.com/736x/92/ec/84/92ec84cda2333f77e6764bb54ead9a1b.jpg",
		 link:"http://porsche.com"},
		];	
		createNextBanner(array,0);


	  function createNextBanner(array,position) {
	        if (position == array.length) {
	          position = 0;
	        }
	        var partner = document.getElementById("ad");
	        partner.src= array[position].src;
	        $scope.bannerLink = array[position].link;
	        position++;
	        $scope.$apply();
	        setTimeout( function(){ 
	        createNextBanner(array,position);        
	        }
	        ,20000 );
	    }

	$scope.clickedOnBanner = function(banner) {

		 var myLatlng = new google.maps.LatLng(48.775846,9.182932);

		var mapOptions = {
            center: myLatlng,
            zoom: 16,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };
 
        var map = new google.maps.Map(document.getElementById("map"), mapOptions);
        map.center = 
		alert("clicked: "+banner);

	}
  
	

  
})


