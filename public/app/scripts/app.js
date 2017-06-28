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
      .otherwise({
        redirectTo: '/'
      });

    /*$locationProvider.html5Mode({
      enabled: true,
      requireBase: false
    });*/
  }])
  .run(function ($localStorage) {
    $localStorage.token = "";
    $localStorage.user = "";

    console.log($localStorage);
  });
