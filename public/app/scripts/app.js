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
      .when('/', {
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
      .when('login', {
        url: '/login',
        templateUrl: 'templates/login.html',
        controller: 'LoginCtrl'
      })

      .when('sign_up', {
        url: '/sign_up',
        templateUrl: 'templates/signUp.html',
        controller: 'SignUpCtrl'
      })

      .when('unable_to_login', {
        url: '/cannot_login',
        templateUrl: 'templates/unableToLogin.html',
        controller: 'UnableToLoginCtrl'
      })
      .otherwise({
        redirectTo: '/login'
      });

    $locationProvider.html5Mode({
      enabled: true,
      requireBase: false
    });
  }])
  .run(function ($localStorage) {
    $localStorage.token = "";
    $localStorage.user = "";

    $rootScope.host_address = "localhost";
    $rootScope.host_address = "192.168.68.145";

    console.log($localStorage);
  });
