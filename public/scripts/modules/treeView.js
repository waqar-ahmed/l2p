(function ( angular ) {
        'use strict';

        angular.module( 'angularTreeview', [] ).directive( 'treeModel', ['$compile', function( $compile ) {
                return {
                        restrict: 'A',
                        link: function ( scope, element, attrs ) {
                                //tree id
                                var treeId = attrs.treeId;
                        
                                //tree model
                                var treeModel = attrs.treeModel;

                                //node id
                                var nodeId = attrs.nodeId || 'id';

                                //node label
                                var nodeLabel = attrs.nodeLabel || 'name';

                                //children
                                var nodeChildren = attrs.nodeChildren || 'nodes';

                                console.log(treeModel);

                                //tree template
                                var template =
                                        '<ul>' +
                                                '<li data-ng-repeat="node in ' + treeModel + ' track by $index">' +
                                                        '<i class="collapsed" data-ng-show="node.' + nodeChildren + '.length && node.collapsed" data-ng-click="' + treeId + '.selectNodeHead(node)"></i>' +
                                                        '<i class="expanded" data-ng-show="node.' + nodeChildren + '.length && !node.collapsed" data-ng-click="' + treeId + '.selectNodeHead(node)"></i>' +
                                                        '<i class="normal" data-ng-hide="node.' + nodeChildren + '.length"></i> ' +
                                                        '<span data-ng-class="node.selected" data-ng-click="' + treeId + '.selectNodeLabel(node)">{{node.' + nodeLabel + '}}</span>' +
                                                        '<div data-ng-hide="node.collapsed" data-tree-id="' + treeId + '" data-tree-model="node.' + nodeChildren + '" data-node-id=' + nodeId + ' data-node-label=' + nodeLabel + ' data-node-children=' + nodeChildren + '></div>' +
                                                '</li>' +
                                        '</ul>';


                                //check tree id, tree model
                                if( treeId && treeModel ) {

                                        //root node
                                        if( attrs.angularTreeview ) {
                                        
                                                //create tree object if not exists
                                                scope[treeId] = scope[treeId] || {};

                                                //if node head clicks,
                                                scope[treeId].selectNodeHead = scope[treeId].selectNodeHead || function( selectedNode ){

                                                        //Collapse or Expand
                                                        selectedNode.collapsed = !selectedNode.collapsed;
                                                };

                                                //if node label clicks,
                                                scope[treeId].selectNodeLabel = scope[treeId].selectNodeLabel || function( selectedNode ){

                                                        //remove highlight from previous node
                                                        if( scope[treeId].currentNode && scope[treeId].currentNode.selected ) {
                                                                scope[treeId].currentNode.selected = undefined;
                                                        }

                                                        //set highlight to selected node
                                                        selectedNode.selected = 'selected';

                                                        //set currentNode
                                                        scope[treeId].currentNode = selectedNode;
                                                };
                                        }

                                        //Rendering template.
                                        element.html('').append( $compile( template )( scope ) );
                                }
                        }
                };
        }]);
})( angular );





// (function(l) {
//   l.module("angularTreeview", []).directive("treeModel", function($compile) {
//     return {
//       restrict: "A",
//       link: function(a, g, c) {
//         var e = c.treeModel,
//           h = c.nodeLabel || "label",
//           d = c.nodeChildren || "children",
//           k = '<ul><li data-ng-repeat="node in ' + e + ' track by $index"><i class="collapsed" data-ng-show="node.' + d + '.length && node.collapsed" data-ng-click="selectNodeHead(node, $event)"></i><i class="expanded" data-ng-show="node.' + d + '.length && !node.collapsed" data-ng-click="selectNodeHead(node, $event)"></i><i class="normal" data-ng-hide="node.' +
//           d + '.length"></i> <span data-ng-class="node.selected" data-ng-click="selectNodeLabel(node, $event)">{{node.' + h + '}}</span><div data-ng-hide="node.collapsed" data-tree-model="node.' + d + '" data-node-id=' + (c.nodeId || "id") + " data-node-label=" + h + " data-node-children=" + d + "></div></li></ul>";
//         e && e.length && (c.angularTreeview ? (a.$watch(e, function(m, b) {
//           g.empty().html($compile(k)(a))
//         }, !1), a.selectNodeHead = a.selectNodeHead || function(a, b) {
//           b.stopPropagation && b.stopPropagation();
//           b.preventDefault && b.preventDefault();
//           b.cancelBubble = !0;
//           b.returnValue = !1;
//           a.collapsed = !a.collapsed
//         }, a.selectNodeLabel = a.selectNodeLabel || function(c, b) {
//           b.stopPropagation && b.stopPropagation();
//           b.preventDefault && b.preventDefault();
//           b.cancelBubble = !0;
//           b.returnValue = !1;
//           a.currentNode && a.currentNode.selected && (a.currentNode.selected = void 0);
//           c.selected = "selected";
//           a.currentNode = c
//         }) : g.html($compile(k)(a)))
//       }
//     }
//   })
// })(angular);






// (function (angular, undefined) {
// 	var module = angular.module('AxelSoft', []);

// 	module.value('treeViewDefaults', {
// 		foldersProperty: 'nodes',
// 		filesProperty: 'files',
// 		displayProperty: 'name',
// 		collapsible: true
// 	});
	
// 	module.directive('treeView', ['$q', 'treeViewDefaults', function ($q, treeViewDefaults) {
// 		return {
// 			restrict: 'A',
// 			scope: {
// 				treeView: '=treeView',
// 				treeViewOptions: '=treeViewOptions'
// 			},
// 			replace: true,
// 			template:
// 				'<div class="tree">' +
// 					'<div tree-view-node="treeView">' +
// 					'</div>' +
// 				'</div>',
// 			controller: ['$scope', function ($scope) {
// 				var self = this,
// 					selectedNode,
// 					selectedFile;

// 				var options = angular.extend({}, treeViewDefaults, $scope.treeViewOptions);

// 				self.selectNode = function (node, breadcrumbs) {
// 					if (selectedFile) {
// 						selectedFile = undefined;
// 					}
// 					selectedNode = node;

// 					if (typeof options.onNodeSelect === "function") {
// 						options.onNodeSelect(node, breadcrumbs);
// 					}
// 				};

// 				self.selectFile = function (file, breadcrumbs) {
// 					if (selectedNode) {
// 						selectedNode = undefined;
// 					}
// 					selectedFile = file;

// 					if (typeof options.onNodeSelect === "function") {
// 						options.onNodeSelect(file, breadcrumbs);
// 					}
// 				};
				
// 				self.isSelected = function (node) {
// 					return node === selectedNode || node === selectedFile;
// 				};

// 				/*
// 				self.addNode = function (event, name, parent) {
// 					if (typeof options.onAddNode === "function") {
// 						options.onAddNode(event, name, parent);
// 					}
// 				};
// 				self.removeNode = function (node, index, parent) {
// 					if (typeof options.onRemoveNode === "function") {
// 						options.onRemoveNode(node, index, parent);
// 					}
// 				};
				
// 				self.renameNode = function (event, node, name) {
// 					if (typeof options.onRenameNode === "function") {
// 						return options.onRenameNode(event, node, name);
// 					}
// 					return true;
// 				};
// 				*/
// 				self.getOptions = function () {
// 					return options;
// 				};
// 			}]
// 		};
// 	}]);

// 	module.directive('treeViewNode', ['$q', '$compile', function ($q, $compile) {
// 		return {
// 			restrict: 'A',
// 			require: '^treeView',
// 			link: function (scope, element, attrs, controller) {

// 				var options = controller.getOptions(),
// 					foldersProperty = options.foldersProperty,
// 					filesProperty = options.filesProperty,
// 					displayProperty = options.displayProperty,
// 					collapsible = options.collapsible;
// 				//var isEditing = false;

// 				scope.expanded = collapsible == false;
// 				//scope.newNodeName = '';
// 				//scope.addErrorMessage = '';
// 				//scope.editName = '';
// 				//scope.editErrorMessage = '';

// 				scope.getFolderIconClass = function () {
// 					return 'icon-folder' + (scope.expanded && scope.hasChildren() ? '-open' : '');
// 				};
				
// 				scope.getFileIconClass = typeof options.mapIcon === 'function' 
// 					? options.mapIcon
// 					: function (file) {
// 						return 'icon-file';
// 					};
				
// 				scope.hasChildren = function () {
// 					var node = scope.node;
// 					return Boolean(node && (node[foldersProperty] && node[foldersProperty].length) || (node[filesProperty] && node[filesProperty].length));
// 				};

// 				scope.selectNode = function (event) {
// 					event.preventDefault();
// 					//if (isEditing) return;

// 					if (collapsible) {
// 						toggleExpanded();
// 					}

// 					var breadcrumbs = [];
// 					var nodeScope = scope;
// 					while (nodeScope.node) {
// 						breadcrumbs.push(nodeScope.node[displayProperty]);
// 						nodeScope = nodeScope.$parent;
// 					}
// 					controller.selectNode(scope.node, breadcrumbs.reverse());
// 				};

// 				scope.selectFile = function (file, event) {
// 					event.preventDefault();
// 					//if (isEditing) return;

// 					var breadcrumbs = [file[displayProperty]];
// 					var nodeScope = scope;
// 					while (nodeScope.node) {
// 						breadcrumbs.push(nodeScope.node[displayProperty]);
// 						nodeScope = nodeScope.$parent;
// 					}
// 					controller.selectFile(file, breadcrumbs.reverse());
// 				};
				
// 				scope.isSelected = function (node) {
// 					return controller.isSelected(node);
// 				};

// 				/*
// 				scope.addNode = function () {
// 					var addEvent = {
// 						commit: function (error) {
// 							if (error) {
// 								scope.addErrorMessage = error;
// 							}
// 							else {
// 								scope.newNodeName = '';
// 								scope.addErrorMessage = '';
// 							}
// 						}
// 					};

// 					controller.addNode(addEvent, scope.newNodeName, scope.node);
// 				};
				
// 				scope.isEditing = function () {
// 					return isEditing;
// 				};

// 				scope.canRemove = function () {
// 					return !(scope.hasChildren());
// 				};
				
// 				scope.remove = function (event, index) {
// 					event.stopPropagation();
// 					controller.removeNode(scope.node, index, scope.$parent.node);
// 				};

// 				scope.edit = function (event) {
// 				    isEditing = true;
// 				    controller.editingScope = scope;
// 					//expanded = false;
// 					scope.editName = scope.node[displayProperty];
// 					event.stopPropagation();
// 				};

// 				scope.canEdit = function () {
// 				    return !controller.editingScope || scope == controller.editingScope;
// 				};

// 				scope.canAdd = function () {
// 				    return !isEditing && scope.canEdit();
// 				};

// 				scope.rename = function (event) {
// 					event.stopPropagation();

// 					var renameEvent = {
// 						commit: function (error) {
// 							if (error) {
// 								scope.editErrorMessage = error;
// 							}
// 							else {
// 								scope.cancelEdit();
// 							}
// 						}
// 					};

// 					controller.renameNode(renameEvent, scope.node, scope.editName);
// 				};

// 				scope.cancelEdit = function (event) {
// 					if (event) {
// 						event.stopPropagation();
// 					}

// 					isEditing = false;
// 					scope.editName = '';
// 					scope.editErrorMessage = '';
// 					controller.editingScope = undefined;
// 				};
// 				*/

// 				function toggleExpanded() {
// 					//if (!scope.hasChildren()) return;
// 					scope.expanded = !scope.expanded;
// 				}

// 				function render() {
// 					var template =
// 						'<div class="tree-folder" ng-repeat="node in ' + attrs.treeViewNode + '.' + foldersProperty + '">' +
// 							'<a href="#" class="tree-folder-header inline" ng-click="selectNode($event)" ng-class="{ selected: isSelected(node) }">' +
// 								'<i class="icon-folder-close" ng-class="getFolderIconClass()"></i> ' +
// 								'<span class="tree-folder-name">{{ node.' + displayProperty + ' }}</span> ' +
// 							'</a>' +
// 							'<div class="tree-folder-content"'+ (collapsible ? ' ng-show="expanded"' : '') + '>' +
// 								'<div tree-view-node="node">' +
// 								'</div>' +
// 							'</div>' +
// 						'</div>' +
// 						'<a href="#" class="tree-item" ng-repeat="file in ' + attrs.treeViewNode + '.' + filesProperty + '" ng-click="selectFile(file, $event)" ng-class="{ selected: isSelected(file) }">' +
// 							'<span class="tree-item-name"><i ng-class="getFileIconClass(file)"></i> {{ file.' + displayProperty + ' }}</span>' +
// 						'</a>';

// 					//Rendering template.
// 					element.html('').append($compile(template)(scope));
// 				}

// 				render();
// 			}
// 		};
// 	}]); 
// })(angular);