app.directive("fileread", [function () {
    return {
        scope: {
            fileread: "="
        },
        link: function (scope, element, attributes) {
            element.bind("change", function (changeEvent) {
                var reader = new FileReader();
                reader.onload = function (loadEvent) {
                    scope.$apply(function () {
                        var checker = loadEvent.target.result.split(':');
                        var isImage = (checker[1].indexOf('image') > -1) ? 'image' : 'not image';
                        scope.fileread = loadEvent.target.result;
                        scope.$root.$broadcast('showAngularImage', isImage);
                        scope.$root.$broadcast('passImage', scope.fileread, element[0].name, isImage);
                    });
                }
                reader.readAsDataURL(changeEvent.target.files[0]);
            });
        }
    }
}])