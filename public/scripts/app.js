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
    'ngTouch'
  ])
  .config(function ($routeProvider) {
    $routeProvider
      .when('/old_main', {
        templateUrl: 'views/main.html',
        controller: 'MainCtrl',
        controllerAs: 'old_main'
      })
      .when('/', {
        templateUrl: 'views/profile_manager.html',
        controller: 'ProfileManagerCtrl',
        controllerAs: 'ProfileManagerCtrl'
      })
      .when('/single_profile', {
        templateUrl: 'views/profile.html',
        controller: 'ProfileCtrl',
        controllerAs: 'ProfileCtrl'
      })
      .otherwise({
        redirectTo: '/'
      });
  });
