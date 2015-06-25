// Ionic Starter App

// angular.module is a global place for creating, registering and retrieving Angular modules
// 'starter' is the name of this angular module example (also set in a <body> attribute in index.html)
// the 2nd parameter is an array of 'requires'
// 'starter.controllers' is found in controllers.js
angular.module('starter', ['ionic', 'starter.controllers'])

.run(function($ionicPlatform) {
  $ionicPlatform.ready(function() {
    // Hide the accessory bar by default (remove this to show the accessory bar above the keyboard
    // for form inputs)
    if (window.cordova && window.cordova.plugins.Keyboard) {
      cordova.plugins.Keyboard.hideKeyboardAccessoryBar(true);
    }
    if (window.StatusBar) {
      // org.apache.cordova.statusbar required
      StatusBar.styleDefault();
    }
  });
})

.factory('JobService', ['$http', '$q', function($http, $q){
  var jobArray = [];
  return {
    
    getAll: function(){
      var myPromise = $q.defer();

      $http.get('http://frontend/mobile/get-jobs').then(function(response){
                  myPromise.resolve(response.data); // resolve our promise -> success
                  jobArray = response.data;
               }, myPromise.reject); // reject our promise -> fail / error case
      return myPromise.promise;
      
    },

    getSpecific: function(job_id){
      var dfd = $q.defer();
      jobArray.forEach(function(job) {
        console.log("Iterator: "+ job.id);
        console.log("Übergabe: "+job_id);
        if (job.id == job_id) {
          console.log("Treffer");
          dfd.resolve(job);
        }
      })
      return dfd.promise;
    }
  };
}])

.config(function($stateProvider, $urlRouterProvider) {
  $stateProvider

  .state('app', {
    url: "/app",
    abstract:true,
    templateUrl: "templates/menu.html",
    controller: 'AppCtrl'
  })

  .state('app.home', {
    url: "/home",
    views: {
      'menuContent': {
        templateUrl: "templates/home.html",
        controller: 'HomeCtrl'

      }
    }
  })

  .state('app.liste', {
    url: "/liste",
    views: {
      'menuContent': {
        templateUrl: "templates/liste.html",
        controller: 'ListCtrl'

      }
    }
  })

   .state('app.listeDetail', {
    url: "/liste/:job_id",
    views: {
      'menuContent': {
        templateUrl: "templates/jobDetail.html",
        controller:"ListDetailCtrl"
      }
    }
  })

  .state('app.events', {
    url: "/events",
    views: {
      'menuContent': {
        templateUrl: "templates/events.html",
        controller: 'EventCtrl'

      }
    }
  })
    .state('app.messages', {
      url: "/messages",
      views: {
        'menuContent': {
          templateUrl: "templates/messages.html",
          controller: 'MessageCtrl'
        }
      }
    })

  .state('app.settings', {
    url: "/settings",
    views: {
      'menuContent': {
        templateUrl: "templates/settings.html",
        controller: 'SettingsCtrl'
      }
    }
  });

  // if none of the above states are matched, use this as the fallback
  $urlRouterProvider.otherwise('/app/home');
});

