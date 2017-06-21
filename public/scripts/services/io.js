/**
 * Created by myazdani on 6/15/2017.
 */

'use strict';

AnalyticsApp.service('fileUpload', ['$http', function ($http) {
    this.uploadFileToUrl = function(file, uploadUrl){
      var fd = new FormData();
      fd.append('file', file);
      $http.post(uploadUrl, fd, {
        transformRequest: angular.identity,
        headers: {'Content-Type': undefined}
      })
        .success(function(){
        })
        .error(function(){
        });
    }
  }]);
