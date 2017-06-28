/**
 * Created by myazdani on 6/19/2017.
 */

'use strict';

AnalyticsApp.directive('fileModel', ['$parse', 'fileService', function ($parse, fileService) {
  return {
    restrict: 'A',
    link: function(scope, element) {
      element.bind('change', function(){
        scope.$apply(function(){
          if (element[0].files !== undefined) {
            console.log(element[0].files[0]);
            console.log(element[0].getAttribute("file-model"));
            // TODO : WARNING: Hardcoded file extension
            var post_upload_name = element[0].getAttribute("file-model") + ".xlsx";
            fileService.push([element[0].files[0], post_upload_name]);
            console.log("FileService so far: " + fileService);
            // TODO : Broadcast to profile controller
            //$rootScope.$broadcast("file_pushed");
            //console.log('directive applying with file');
          } else {
            console.log("FILES ARE UNDEFINED")
          }
        });
      });
    }
  };
}]);
