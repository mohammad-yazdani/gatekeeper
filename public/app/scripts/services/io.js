/**
 * Created by myazdani on 6/15/2017.
 */

'use strict';

angular
  .module('analyticsApp').service('fileUpload', ['$http', '$rootScope', function ($http, $rootScope) {
    this.uploadFileToUrl = function(file, uploadUrl){
      var fd = new FormData();
      fd.append('file', file);

      console.log("Upload service ...");
      console.log(uploadUrl);
      console.log("uploading " + file.name);

      $http.post(uploadUrl, fd, {
        transformRequest: angular.identity
        , headers: {'Content-Type': undefined}
      }).then(function successCallback(response) {

        if (parseInt(response.status) === 200) {
          // TODO : Broadcast to profile ctrl
          $rootScope.$broadcast('profile_upload_failed');

          console.log("Upload failed: ");
          console.log(response.status);
          console.log(response.headers);
          console.log(response.content);
        } else {
          console.log("Upload successful: ");
          console.log(response.status);
          console.log(response.headers);
          console.log(response.content);
        }

      }, function errorCallback(response) {
        console.log("Upload failed: ");
        console.log(response.status);
        console.log(response.headers);
        console.log(response.content);
      });
    };

    this.downloadFromUrl = function (downloadUrl) {
      window.location.assign(downloadUrl);
      return true;
    }
  }]);
