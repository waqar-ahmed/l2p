app.controller('singlecourseCtrl', function($scope,$stateParams) {

	console.log("course ID: " + $stateParams.id);


	$scope.breadcrums = [''];
					
					$scope.structure = { folders: [
						{ name: 'Folder 1', files: [{ name: 'File 1.jpg' }, { name: 'File 2.png' }], folders: [
							{ name: 'Subfolder 1', files: [{ name: 'Subfile 1.txt' }] },
							{ name: 'Subfolder 2' },
							{ name: 'Subfolder 3' }
						]},
						{ name: 'Folder 2' }
					], files: [{ name: 'File 1.gif' }, { name: 'File 2.gif' }]};
					
					$scope.options = {
						onNodeSelect: function (node, breadcrums) {
							$scope.breadcrums = breadcrums;
						}
					};
					
					$scope.options2 = {
						collapsible: false
					};
					
					var iconClassMap = {
						txt: 'icon-file-text',
						jpg: 'icon-picture blue',
						png: 'icon-picture orange',
						gif: 'icon-picture'
					},
						defaultIconClass = 'icon-file';
					
					$scope.options3 = {
						mapIcon: function (file) {
							var pattern = /\.(\w+)$/,
								match = pattern.exec(file.name),
								ext = match && match[1];
							
							return iconClassMap[ext] || defaultIconClass;
						}
					};



});
