/*!
 * com_remoteimage
 *
 * Copyright 2012 Asikart.com
 * License GNU General Public License version 2 or later; see LICENSE.txt, see LICENSE.php
 *
 * Generator: AKHelper
 * Author: Asika
 */

var Remoteimage = {
	
}


// Init elFinder
var elSelected ;
var el ;

jQuery().ready(function($) {
	var elf = $('#elfinder').elfinder({
		url : 'index.php?option=com_remoteimage&task=manager' ,
		width : '100%' ,
		handlers : {
			select : function(event, elfinderInstance) {
				var selected = event.data.selected;

				if (selected.length) {
					elSelected = [];
					jQuery.each(selected, function(i, e){
						elSelected[i] = elfinderInstance.file(e);
					});
				}

			}
		}
	}).elfinder('instance');
});