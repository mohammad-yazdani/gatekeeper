/**
 * Created by Mohammad Yazdani on 2017-07-04.
 */

'use strict';

AnalyticsApp.service('Server', ['$rootScope', '$timeout', '$http', '$localStorage',
  function ($rootScope, $timeout, $http, $localStorage) {

  this.baseAddress = "http://" + $rootScope.host_address + "/gatekeeper/index.php/";
  this.authAddress = "ClientAuth";
  //this.authAddress = "AnalyticsAuth";

    this.login = function (username, password) {
    var params = "/null/" + username + "/" + password;

    return $http.get(this.baseAddress + this.authAddress + params, null)
      .then(function (response) {
        // console.log(response);
        // console.log(response.data);
        // console.log(response.status);
        if (response.status !== 202) {
          console.log("Login error!");
          console.log(response);
        }
        return response.data;
      }, function (response) {
        console.log(response);
      });
  };

  this.autoLogin = function (token) {
    //var params = "/" + token + "/null/null";
    var params = "";

    $http({
      method: 'POST',
      url: this.baseAddress + this.authAddress + params,
      headers: {
        //'Authorization': 'Bearer ' + token
        //or
        'Authorization': 'Basic ' + token
      }
    }).then(function successCallback(response) {
      $log.log("OK")
    }, function errorCallback(response) {
      if(response.status = 401){ // If you have set 401
        $log.log("ohohoh")
      }
    });
    return;
    return $http.get(this.baseAddress + this.authAddress + params,
      {
       headers: {
        "Authorization": 'Bearer ' + token
       }
      }
    )
      .then(function (response) {
        // console.log(response);
        // console.log(response.data);
        // console.log(response.status);
        console.log("GET Response: " + response.data);
        if (response.status !== 202) {
          console.log("Login error!");
        }
        return response.data;
      }, function (response) {
        console.log(response);
      });
  };

  this.signUp = function (username, password, email) {

  };

  this.checkUsername = function (username) {

  };
  this.checkEmail = function (email) {

  };

  this.forgotPassword = function (username) {

  };

  this.forgotUsername = function (email) {

  };

}]);
