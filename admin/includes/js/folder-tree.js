/*!
 * com_remoteimage
 *
 * Copyright 2012 Asikart.com
 * License GNU General Public License version 2 or later; see LICENSE.txt, see LICENSE.php
 *
 * Generator: AKHelper
 * Author: Asika
 */

var rmServerUrl = 'index.php?option=com_remoteimage&task=manager.server&type=ftp' ;
var tmp ;

var pathToId = function(path){
	
	console.log(path);
	if(path){
		id = path.toString().replace(/\//ig, '-') ;
		return id ;
	}else{
		return null;
	}
}

jQuery(document).ready(function($){
	
	var folderTree = $("#remote-folder-wrap") ;
	
	$(function () {

		
			folderTree.bind("before.jstree", function (e, data) {
				$("#alog").append(data.func + "<br />");
				//console.log(data.func);
			})
			.jstree({ 
				// List of active plugins
				"plugins" : [ 
					"themes","json_data","ui","crrm","cookies","dnd","search","types","hotkeys","contextmenu" 
				],
		
				// I usually configure the plugin that handles the data first
				// This example uses JSON as it is most common
				"json_data" : { 
					// This tree is ajax enabled - as this is most common, and maybe a bit more complex
					// All the options are almost the same as jQuery's AJAX (read the docs)
					"ajax" : {
						// the URL to fetch the data
						"url" : rmServerUrl,
						// the `data` function is executed in the instance's scope
						// the parameter is the node being loaded 
						// (may be -1, 0, or undefined when loading the root nodes)
						"data" : function (n) { 
							// the result is fed to the AJAX request `data` option
							
							return { 
								"operation" : "getChildren", 
								"path" : n.attr ? n.attr('path') : null,
								"root" : n.attr ? 0 : 1 
							}; 
						}
					}
				},
				// Configuring the search plugin
				"search" : {
					// As this has been a common question - async search
					// Same as above - the `ajax` config option is actually jQuery's AJAX object
					"ajax" : {
						"url" : "index.php?option=remoteimage&task=manager.server&type=ftp",
						// You get the search string as a parameter
						"data" : function (str) {
							return { 
								"operation" : "search", 
								"search_str" : str 
							}; 
						}
					}
				},
				// Using types - most of the time this is an overkill
				// read the docs carefully to decide whether you need types
				"types" : {
					// I set both options to -2, as I do not need depth and children count checking
					// Those two checks may slow jstree a lot, so use only when needed
					"max_depth" : -2,
					"max_children" : -2,
					// I want only `drive` nodes to be root nodes 
					// This will prevent moving or creating any other type as a root node
					"valid_children" : [ "drive" ],
					"types" : {
						// The default type
						"default" : {
							// I want this type to have no children (so only leaf nodes)
							// In my case - those are files
							"valid_children" : "none",
							// If we specify an icon for the default type it WILL OVERRIDE the theme icons
							"icon" : {
								"image" : "components/com_remoteimage/images/folder-tree/file.png"
							}
						},
						// The `folder` type
						"folder" : {
							// can have files and other folders inside of it, but NOT `drive` nodes
							"valid_children" : [ "default", "folder" ],
							"icon" : {
								"image" : "components/com_remoteimage/images/folder-tree/folder.png"
							}
						},
						// The `drive` nodes 
						"drive" : {
							// can have files and folders inside, but NOT other `drive` nodes
							"valid_children" : [ "default", "folder" ],
							"icon" : {
								"image" : "components/com_remoteimage/images/folder-tree/root.png"
							},
							// those prevent the functions with the same name to be used on `drive` nodes
							// internally the `before` event is used
							"start_drag" : false,
							"move_node" : false,
							"delete_node" : false,
							"remove" : false
						}
					}
				},
				// UI & core - the nodes to initially select and open will be overwritten by the cookie plugin
		
				// the UI plugin - it handles selecting/deselecting/hovering nodes
				"ui" : {
					// this makes the node with ID node_4 selected onload
					"initially_select" : [ "rmpath-root" ]
				},
				// the core plugin - not many options here
				"core" : { 
					// just open those two nodes up
					// as this is an AJAX enabled tree, both will be downloaded from the server
					"initially_open" : [ "rmpath-root" ] 
				}
			})
			.bind("create.jstree", function (e, data) {
				tmp = data ;
				$.get(
					rmServerUrl, 
					{
						"operation" : "createNode", 
						"id" : pathToId(this.path), 
						"path" : data.rslt.parent.attr('path'),
						"title" : data.rslt.name,
						"type" : data.rslt.obj.attr("rel")
					}, 
					function (r) {
						if(r.status) {
							$(data.rslt.obj).attr("id", "node_" + r.id);
							$(data.rslt.obj).attr("path", r.path);
						}
						else {
							$.jstree.rollback(data.rlbk);
						}
					},
					'json'
				);
			})
			.bind("remove.jstree", function (e, data) {
				
				data.rslt.obj.each(function () {
					//tmp = data ;
					$.ajax({
						async : false,
						type: 'GET',
						dataType: "json",
						url: rmServerUrl,
						data : { 
							"operation" : "removeNode", 
							"path" : data.rslt.obj.attr('path')
						}, 
						success : function (r) {
							if(!r.status) {
								if(r.msg) {
									alert(r.msg);
								}
								folderTree.jstree('refresh', '#'+data.rslt.parent.attr('id') ) ;
							}else{
								//folderTree.jstree('refresh', '#'+data.rslt.parent.attr('id') ) ;
							}
						}
					});
				});
			})
			.bind("rename.jstree", function (e, data) {
				$.post(
					rmServerUrl, 
					{ 
						"operation" : "renameNode", 
						"path" : data.rslt.parent.attr('path'),
						"title" : data.rslt.new_name,
						"id" : pathTpId(this.path)
					}, 
					function (r) {
						if(!r.status) {
							$.jstree.rollback(data.rlbk);
						}
					},
					'json'
				);
			})
			.bind("move_node.jstree", function (e, data) {
				data.rslt.o.each(function (i) {
					$.ajax({
						async : false,
						type: 'GET',
						dataType: "json",
						url: rmServerUrl,
						data : { 
							"operation" : "moveNode", 
							"path" : data.rslt.cr === -1 ? 1 : data.rslt.np.attr("path"), 
							"position" : data.rslt.cp + i,
							"title" : data.rslt.name,
							"copy" : data.rslt.cy ? 1 : 0
						},
						success : function (r) {
							if(!r.status) {
								$.jstree.rollback(data.rlbk);
							}
							else {
								$(data.rslt.oc).attr("id", "node_" + r.id);
								if(data.rslt.cy && $(data.rslt.oc).children("UL").length) {
									data.inst.refresh(data.inst._get_parent(data.rslt.oc));
								}
							}
							//$("#analyze").click();
						}
					});
				});
			});
		
	});
	
	
	
	// Menu
	// Code for the menu buttons
	$(function () { 
		$("#remote-folder-menu input").click(function () {
			switch(this.id) {
				case "add_default":
				case "add_folder":
					folderTree.jstree("create", null, "last", { "attr" : { "rel" : this.id.toString().replace("add_", "") } });
					break;
				case "search":
					folderTree.jstree("search", document.getElementById("text").value);
					break;
				case "text": break;
				default:
					folderTree.jstree(this.id);
					break;
			}
		});
	});
});



