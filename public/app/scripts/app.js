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

      .when('sign_up', {
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

    /*$locationProvider.html5Mode({
      enabled: true,
      requireBase: false
    });*/
  }])
  .run(function ($localStorage, $rootScope) {
    //$localStorage.token = "";
    console.log("Present token: " + $localStorage.token);
    $rootScope.lastCallBack = "";
    $rootScope.host_address = "localhost";
    // $rootScope.host_address = "192.168.68.145";

    // console.log($localStorage);
  });
