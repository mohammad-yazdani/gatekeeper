'use strict';

/**
 * @ngdoc overview
 * @name analyticsApp
 * @description
 * # analyticsApp
 *
 * Main module of the application.
 */
var AnalyticsApp = angular
  .module('analyticsApp', [
    'ngAnimate',
    'ngAria',
    'ngCookies',
    'ngMessages',
    'ngResource',
    'ngRoute',
    'ngSanitize',
    'ngTouch',
    'ngStorage'
  ])
  .config(['$routeProvider', '$locationProvider',function ($routeProvider, $locationProvider) {
    $routeProvider
      .when('/old_main', {
        templateUrl: 'views/main.html',
        controller: 'MainCtrl',
        controllerAs: 'old_main'
      })
      .when('/catalog', {
        templateUrl: 'views/catalog.html',
        controller: 'CatalogCtrl',
        controllerAs: 'CatalogCtrl'
      })
      .when('/analytics', {
        templateUrl: 'views/profile_manager.html',
        controller: 'ProfileManagerCtrl',
        controllerAs: 'ProfileManagerCtrl'
      })
      .when('/single_profile', {
        templateUrl: 'views/profile.html',
        controller: 'ProfileCtrl',
        controllerAs: 'ProfileCtrl'
      })
      .when('/config_profile', {
        templateUrl: 'views/profile_config.html',
        controller: 'ProfileConfig',
        controllerAs: 'ProfileConfig'
      })
      .when('/loading', {
        templateUrl: 'views/loading.html',
        controller: 'ProfileCtrl',
        controllerAs: 'ProfileCtrl'
      })
      .when('/', {
        url: '/login',
        templateUrl: 'views/login.html',
        controller: 'LoginCtrl'
      })
      .when('/test', {
        url: '/test',
        templateUrl: 'views/test/login-test.html',
        controller: 'LoginTestCtrl'
      })

      .when('/sign_up', {
        url: '/sign_up',
        templateUrl: 'views/signup.html',
        controller: 'SignUpCtrl'
      })

      .when('unable_to_login', {
        url: '/cannot_login',
        templateUrl: 'views/forgot_password.html',
        controller: 'UnableToLoginCtrl'
      })

      .otherwise({
        redirectTo: '/login'
      });
  }])
  .run(["$localStorage", "$rootScope", "$location",
    function ($localStorage, $rootScope, $location) {
    if (!$localStorage.token) {
      $location.token = "";
    }
    $rootScope.lastCallBack = "";
    $rootScope.host_address = "localhost";
    //$rootScope.host_address = "192.168.68.145";
    $rootScope.logOut = function () {
      $localStorage.token = "";
      $localStorage.user = "";
      $rootScope.current_user_name = $localStorage.user;
      $location.path("/");
    };

    $rootScope.home = function () {
      $location.path("/catalog");
    };
  }]);
