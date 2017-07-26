/**
 * Created by Mohammad Yazdani on 2017-07-04.
 */

// TODO : CLEAN-CODE

'use strict';

AnalyticsApp.service('Server', ['$rootScope', '$timeout', '$http', '$localStorage', '$location',
  function ($rootScope, $timeout, $http, $localStorage, $location) {
    this.host = $rootScope.host_address;
    this.baseAddress = "http://" + this.host + "/gatekeeper_dev/index.php/";
    this.authAddress = "ClientAuth";

    this.login = function (username, password) {
      return $http({
        method: 'GET',
        url: this.baseAddress + this.authAddress,
        headers: {
          'username': username,
          'password': password
        }
      })
        .then(function (response) {
          return response;
        }, function (response) {
          return response;
        });
    };

    this.register = function (username, password, email, data) {
      var json_data = Object();
      json_data.username = username;
      json_data.password = password;
      json_data.email = email;
      json_data.data = data;
      return $http.post(this.baseAddress + this.authAddress, JSON.stringify(json_data))
        .then(function successCallback(response) {
          $localStorage.token = response.headers('token');
          return response;
        }, function errorCallback(response) {
          console.log(response);
          return response;
        });
    };


    this.autoLogin = function (token) {
      $http({
        method: 'POST',
        url: this.baseAddress + this.authAddress,
        headers: {
          'token': token
        }
      }).then(function successCallback(response) {
        return response;
      }, function errorCallback(response) {
        if(response.status = 401){ // If you have set 401
          $log.log("Server->autoLoad error")
        }
      })
        .then(function (response) {
          return response.headers('token');
          }, function (response) {
          console.log(response);
        });
    };

    this.checkSession = function () {
      console.log('Checking session: ');
      $http({
        method: 'GET',
        url: this.baseAddress + this.authAddress,
        headers: {
          'token': $localStorage.token
        }
      }).then(function successCallback(response) {
        $localStorage.token = response.headers('token');
        if (!$localStorage.token) {
          $localStorage.token = "";
          $location.path("/");
        }
      }, function errorCallback(response) {
        $location.path("/");
        return response;
      })
    };

    this.uploadFileToUrl = function(file, uploadUrl){
      var fd = new FormData();
      fd.append('file', file);
      $http.post(uploadUrl, fd, {
        transformRequest: angular.identity
        , headers: {'Content-Type': undefined}
      }).then(function successCallback(response) {
        if (parseInt(response.status) === 200) {
          $rootScope.$broadcast('profile_upload_failed');
          console.log("Upload failed: ");
          return response;
        } else {
          console.log("Upload successful: ");
          return response;
        }

      }, function errorCallback(response) {
        $rootScope.$broadcast('profile_upload_failed');
        console.log("Upload failed: ");
        return response;
      });
    };

    this.downloadFromUrl = function (downloadUrl) {
      window.location.assign(downloadUrl);
      return true;
    };

    /*
    this.checkUsername = function (username) {

    };
    this.checkEmail = function (email) {

    };
    this.forgotPassword = function (username) {

    };
    this.forgotUsername = function (email) {

    };
    */

    // TODO : BEFORE ANY CALL
    this.checkSession();
}]);
