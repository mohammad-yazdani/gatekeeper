/**
 * Created by Mohammad Yazdani on 2017-07-04.
 */

// TODO : CLEAN-CODE

'use strict';
AnalyticsApp.controller('LoginCtrl', ['$scope', 'fileService', '$rootScope',
  '$localStorage', '$location', '$window', 'Server',
  function ($scope, fileService, $rootScope,
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
        Server.autoLogin($localStorage.token)
          .then(function (data) {
            if (data.headers('token').length > 1) {
              $localStorage.token = data;
              $location.path("/catalog");
            } else {
              $scope.error = data.data.replace(/_/g, ' ');
            }
          });
      }
    };

    $scope.login = function () {
      if (!$scope.username || $scope.username.length <= 0) {
        $scope.error = "Username field empty!";
        return;
      }
      if (!$scope.password || $scope.password.length <= 0) {
        $scope.error = "Password field empty!";
        return;
      }
      Server.login($scope.username, $scope.password)
        .then(function (data) {
          if (data.headers('token').length > 1) {
            $localStorage.token = data;
            $localStorage.user = $scope.username;
            $location.path("/catalog");
          } else {
            $scope.error = data.data.replace(/_/g, ' ');
          }
        });
    };
    $scope.goToSignUp = function () {
      $location.path("/sign_up");
    };
}]);
