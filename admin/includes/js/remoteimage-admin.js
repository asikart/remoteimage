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
    insertImages : function(id, imgs, urls, elFinder, option){
        var tags = '';
        
        // Handle From Urls
        urls = urls.toString().trim();
        
        if( urls ) {
            urls = urls.split("\n");
            
            urls.each( function(e, i){
                var path = e.split('/');
                var ext = path.getLast().split('.').getLast();
                var img_ext = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'svg'];
                
                if(!e.trim()) {
                    return;
                }
                
                if( img_ext.contains(ext.toLowerCase()) ) {
                    // Create img element
                    var img = new Element('img', {
                        alt : path.getLast() ,
                        src : e
                    }) ;
                    
                    // Fix Width
                    if( option.fixAll ) {
                        img.set('width', option.dW) ;
                    }
                    
                    tags += option.insert_template_image.replace( '{%CONTENT%}' ,img.outerHTML);
                }else{
                    var a = new Element('a', {
                        href : e,
                        target : '_blank',
                        text : path.getLast()
                    });
                    
                    tags += '&nbsp; ' + option.insert_template_link.replace( '{%CONTENT%}' ,a.outerHTML) + '&nbsp; ' ;
                }
                
            });
        }else{
            // Insert From Selected
            if( imgs.length < 1 ) {
                return ;
            }
            
            imgs.each( function(e, i){
            
                if( e.mime.split('/')[0] == 'image' ) {
                    // Create img element
                    var img = new Element('img', {
                        alt : e.name ,
                        src : elFinder.url(e.hash)
                    }) ;
                    
                    // Fix Width
                    if( option.fixAll ) {
                        img.set('width', option.dW) ;
                    }
                    
                    tags += option.insert_template_image.replace( '{%CONTENT%}' ,img.outerHTML);
                }else{
                    var a = new Element('a', {
                        href : elFinder.url(e.hash),
                        target : '_blank',
                        text : e.name
                    });
                    
                    tags += '&nbsp; ' + option.insert_template_link.replace( '{%CONTENT%}' ,a.outerHTML) + '&nbsp; ' ;
                }
                
            } );
        }
        
        
        jInsertEditorText(tags, id);
        SqueezeBox.close();

    }
}


