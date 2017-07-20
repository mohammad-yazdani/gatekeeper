/**
 * Created by Mohammad Yazdani on 2017-07-04.
 */

'use strict';

AnalyticsApp.controller('LoginCtrl', ['$scope', 'fileUpload', 'fileService', '$rootScope',
  '$localStorage', '$location', '$window', 'Server',
  function ($scope, fileUpload, fileService, $rootScope,
            $localStorage, $location, $window, Server) {

    $scope.username = $localStorage.user;
    $scope.password = null;
    $scope.error = null;
    $localStorage.token = "";

    $scope.doLogin = function () {
      if ($localStorage.token.length > 1 && !$scope.password) {
        $scope.autoLogin();
      } else {
        $scope.login($scope.username, $scope.password);
      }
    };

    $scope.autoLogin = function () {
      if ($localStorage.token) {
        var result = Server.autoLogin($localStorage.token)
          .then(function (data) {
            if (data.length > 1) {
              $localStorage.token = data;
              console.log("Transfer");
              $location.path("/catalog");
            }
          });
      }
    };

    $scope.login = function () {
      // TODO : Get username from input
      // TODO : Get password from input
      console.log("Login begin..");

      if (!$scope.username || $scope.username.length <= 0) {
        $scope.error = "Username field empty!";
        return;
      }

      if (!$scope.password || $scope.password.length <= 0) {
        $scope.error = "Password field empty!";
        return;
      }

      // TODO : Call cred login
      var result = Server.login($scope.username, $scope.password)
        .then(function (data) {
          if (data.length > 1) {
            $localStorage.token = data;
            console.log("Transfer");
            $localStorage.user = $scope.username;
            $location.path("/catalog");
          }
        });
    };

    $scope.goToSignUp = function () {
      console.log("Sign up");
      $location.path("/sign_up");
    };

    // if (!$scope.autoLogin()) console.log("Token login didn't work, use cred login!");
}]);
