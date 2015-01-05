/**
 * com_remoteimage
 *
 * Copyright 2012 Asikart.com
 * License GNU General Public License version 2 or later; see LICENSE.txt, see LICENSE.php
 *
 * Generator: AKHelper
 * Author: Asika
 */

var Remoteimage = {

	/**
	 * Insert images, this js file will load in every pages if you enabled the com_media replacement.
	 *
	 * @param id
	 * @param imgs
	 * @param urls
	 * @param elFinder
	 * @param option
	 */
	insertImages: function(id, imgs, urls, elFinder, option)
	{
		var tags = '';

		// Handle From Urls
		urls = urls.toString().trim();

		if (urls)
		{
			urls = urls.split("\n");

			urls.each(function(e, i)
			{
				var path = e.split('/');
				var ext = path.getLast().split('.').getLast();
				var img_ext = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'svg'];

				if (!e.trim())
				{
					return;
				}

				if (img_ext.contains(ext.toLowerCase()))
				{
					// Create img element
					var img = new Element('img', {
						alt: path.getLast(),
						src: e
					});

					// Fix Width
					if (option.fixAll)
					{
						img.set('width', option.dW);
					}

					tags += option.insert_template_image.replace('{%CONTENT%}', img.outerHTML);
				}
				else
				{
					var a = new Element('a', {
						href: e,
						target: '_blank',
						text: path.getLast()
					});

					tags += '&nbsp; ' + option.insert_template_link.replace('{%CONTENT%}', a.outerHTML) + '&nbsp; ';
				}

			});
		}
		else
		{
			// Insert From Selected
			if (imgs.length < 1)
			{
				return;
			}

			imgs.each(function(e, i)
			{
				var url = elFinder.url(e.hash);

				if (url.indexOf(option.root_uri) == 0)
				{
					url = url.substr(option.root_uri.length);
				}

				if (e.mime.split('/')[0] == 'image')
				{
					// Create img element
					var img = new Element('img', {
						alt: e.name,
						src: url
					});

					// Fix Width
					if (option.fixAll)
					{
						img.set('width', option.dW);
					}

					tags += option.insert_template_image.replace('{%CONTENT%}', img.outerHTML);
				}
				else
				{

					var a = new Element('a', {
						href: url,
						target: '_blank',
						text: e.name
					});

					tags += '&nbsp; ' + option.insert_template_link.replace('{%CONTENT%}', a.outerHTML) + '&nbsp; ';
				}

			});
		}

		jInsertEditorText(tags, id);
		SqueezeBox.close();
	}
};
