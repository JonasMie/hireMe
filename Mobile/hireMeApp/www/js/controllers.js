angular.module('starter.controllers', [])


.controller('AppCtrl', function($scope, $ionicModal, $timeout,$http) {


})

.controller('HomeCtrl', function($scope, $ionicLoading, $compile,$http,$ionicSideMenuDelegate,$rootScope) {

	var jobs = [];
	var markers = [];

		var options = {
        	enableHighAccuracy: true,
        	timeout: 50000,
        	maximumAge: 0
    	};

       	navigator.geolocation.watchPosition(updatePosition, errorOnUpdating, options);
     	navigator.geolocation.getCurrentPosition(loadIt, errorOnUpdating,options);


		$ionicSideMenuDelegate.canDragContent(false);
		      
        var myLatlng = new google.maps.LatLng(48.775846,9.182932);
 
        var mapOptions = {
            center: myLatlng,
            zoom: 16,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };
 
        var map = new google.maps.Map(document.getElementById("map"), mapOptions);
        var myLocation;

        function errorOnUpdating(err) {

        	alert("hat nicht geklappt");
        }

        function applyTo(jobID) {

        	alert("applied to: "+jobID);
        }

        function loadIt(pos) {

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
		 
        }
 	
        function updatePosition(pos) {
        	myLocation.setPosition(new google.maps.LatLng(pos.coords.latitude, pos.coords.longitude));
            map.setCenter(new google.maps.LatLng(pos.coords.latitude, pos.coords.longitude));
        }


      $http.get('http://frontend/mobile/get-jobs')

 		.success(function(data, status, headers, config) {
 
       		console.log(data);
       		jobs = data;
       		$rootScope.jobs = data;

       		if (status == 200) {
       		for (var i = 0; i < data.length; i++) {

       			var job = data[i];
       			var contentString = "<div><h2>"+job.title+"</h2><p>"+job.description+"</p><button id='applyBtn'>Jetzt bewerben</button></div>";
                var compiled = $compile(contentString)($scope);
  				  var infowindow = new google.maps.InfoWindow({
                    content: compiled[0]
                 });
  				$rootScope.infowindow = infowindow;
                       
       			var jobPosition = new google.maps.Marker({
                position: new google.maps.LatLng(job.latitude,job.longitude),
                map: map,
                animation: google.maps.Animation.DROP,
                title: "My Location",
                html:compiled[0]
            	});
       			markers.push(jobPosition);
				if (i==0) {$rootScope.marker1 = jobPosition;}
				else if(i==1) {$rootScope.marker2 = jobPosition;}       			
       			$rootScope.$apply();

       			}
       		}


       		for (var i = 0; i < markers.length; i++) {

         	 var marker = markers[i];

             google.maps.event.addListener(marker, 'click', function () {
                 infowindow.setContent(this.html);
                 infowindow.open(map, this);
         	 });

         	 google.maps.event.addListener(infowindow, 'domready', function() {
				   var btn = document.getElementById("applyBtn");
				   google.maps.event.addDomListener(btn,"click",function() {
			       	

			       	// TODO: APPLY HERE!!!

			    });
			});

       		 }
       		 $rootScope.markers = markers;
       		 $scope.map = map;  
			$rootScope.map = map;
			$rootScope.$apply();

       });


})
.controller('ListCtrl',['$scope','$ionicSideMenuDelegate','JobService', function($scope,$ionicSideMenuDelegate, JobService){

  		$ionicSideMenuDelegate.canDragContent(true);

      $scope.jobs = [];
      JobService.getAll().then(function (jobs) {
        $scope.jobs = jobs;

      }, function (response) {
          // our q.reject gets the reponse and you can handle an error
          console.log("Rejected connection for JobService");
      })


     $scope.doRefresh = function() {
           JobService.getAllItems().then(function (jobs) {
          $scope.jobs = jobs;     
            $scope.$broadcast('scroll.refreshComplete');
          })
          .finally(function() {
            // Stop the ion-refresher from spinning
            $scope.$broadcast('scroll.refreshComplete');
          })
      }
  
}])

.controller('EventCtrl', function($scope,$ionicSideMenuDelegate,$http,$ionicModal) {

  function makeHttpObject() {
  try {return new XMLHttpRequest();}
  catch (error) {}
  try {return new ActiveXObject("Msxml2.XMLHTTP");}
  catch (error) {}
  try {return new ActiveXObject("Microsoft.XMLHTTP");}
  catch (error) {}

  throw new Error("Could not create HTTP request object.");
  }

  $ionicModal.fromTemplateUrl('./templates/newEventModal.html', {
    scope:$scope,
    animation: 'slide-in-up'
    }).then(function(modal) {
      $scope.modal = modal;
    })

  $scope.sendData = function() {

    var thisEvent = {
     title:"Hevent title",
     description:"description",
     begin:"0",
     end:"0"
    };
    var url = 'http://frontend/mobile/create-event?thisevent='+thisEvent;

    $http(
    {
      method:'GET',
      url:url,
      headers: {
        'Content-type':'application/json',
        'X-Requested-With': 'XMLHttpRequest'
      }
    })
    .success(function(data,status,headers,config) {

      alert(status);

    })
/*
     var request1 = makeHttpObject();
    request1.open("GET", "http://frontend/mobile/create-event?thisevent="+thisEvent, true);
    request1.send(null);

    request1.onreadystatechange = function() {

        if (request1.readyState == 4) {


        }

    }
    /*
    alert(thisEvent.title);

    $http({
    url: url,
    method: "GET",
    params: {event:thisEvent}
    });
*/

  }

  $scope.newEvent = function() {

    $scope.modal.show();

  }
    	
    	$ionicSideMenuDelegate.canDragContent(true);

   $scope.events = [];

  		getEvents();

  		function getEvents() {

		 $http.get('http://frontend/mobile/get-events')

		 		.success(function(data, status, headers, config) {
		 
		       		console.log(data);
		       		if (status == 200) {
		       		for (var i = 0; i < data.length; i++) {

		       			var job = data[i];
		       			$scope.events.push(job);
		       			}
		       		}

		       })
		}
  

  
})

.controller('MessageCtrl', function($scope,$ionicSideMenuDelegate) {
     	
     	$ionicSideMenuDelegate.canDragContent(true);
 

  
})

.controller('SettingsCtrl', function($scope,$ionicSideMenuDelegate) {
  
    	$ionicSideMenuDelegate.canDragContent(true);

  
})

.controller('ListDetailCtrl', function($scope,$ionicSideMenuDelegate,$stateParams, JobService) {
  
      $ionicSideMenuDelegate.canDragContent(true);

       $scope.openLink = function(link) {

      navigator.app.loadUrl(link, { openExternal:true });
      }
      $scope.job = "";
      var jobID = $stateParams.job_id;
      JobService.getSpecific(jobID).then(function (jobReceived) {
        $scope.job = jobReceived;
      }, function (response) {
          // our q.reject gets the reponse and you can handle an error
          console.log("Rejected connection for JobService");
      });

})

.controller('AdCtrl', function($scope,$ionicSideMenuDelegate,$rootScope) {

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

		var jobLatLng = new google.maps.LatLng(48.96035800,9.06432100);
		// TODO: implement static lat/lng

        $rootScope.map.setCenter(jobLatLng);
        $rootScope.map.setZoom(16);
       

	}
  
	

  
})


