/*
Copyright (c) 2003-2010, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/

CKEDITOR.plugins.add( 'internalLink',
{
	init : function( editor )
	{
		// Add the link and unlink buttons.
		editor.addCommand( 'internalLink', new CKEDITOR.dialogCommand( 'internalLink' ) );
		editor.ui.addButton( 'Internal Link',
			{
				label : "Internal Link";//editor.lang.link.toolbar,
				command : 'internalLink'
			} );
		CKEDITOR.dialog.add( 'internalLink', this.path + 'dialogs/internalLink.js' );

		// Add the CSS styles for anchor placeholders.
		//editor.addCss(
			//'img.cke_anchor' +
			//'{' +
				//'background-image: url(' + CKEDITOR.getUrl( this.path + 'images/anchor.gif' ) + ');' +
				//'background-position: center center;' +
				//'background-repeat: no-repeat;' +
				//'border: 1px solid #a9a9a9;' +
				//'width: 18px;' +
				//'height: 18px;' +
			//'}\n' +
			//'a.cke_anchor' +
			//'{' +
				//'background-image: url(' + CKEDITOR.getUrl( this.path + 'images/anchor.gif' ) + ');' +
				//'background-position: 0 center;' +
				//'background-repeat: no-repeat;' +
				////'border: 1px solid #a9a9a9;' +
				//'padding-left: 18px;' +
			//'}'
		   	//);

		// Register selection change handler for the unlink button.
		 //editor.on( 'selectionChange', function( evt )
			//{
				///*
				 //* Despite our initial hope, document.queryCommandEnabled() does not work
				 //* for this in Firefox. So we must detect the state by element paths.
				 //*/
				//var command = editor.getCommand( 'unlink' ),
					//element = evt.data.path.lastElement.getAscendant( 'a', true );
				//if ( element && element.getName() == 'a' && element.getAttribute( 'href' ) )
					//command.setState( CKEDITOR.TRISTATE_OFF );
				//else
					//command.setState( CKEDITOR.TRISTATE_DISABLED );
			//} );

		// If the "menu" plugin is loaded, register the menu items.
		if ( editor.addMenuItems )
		{
			editor.addMenuItems(
				{
					link :
					{
						label : "Internal Link",
						command : 'internalLink',
						group : 'link',
						order : 1
					},
				});
		}

		// If the "contextmenu" plugin is loaded, register the listeners.
		if ( editor.contextMenu )
		{
			editor.contextMenu.addListener( function( element, selection )
				{
					if ( !element )
						return null;

					return	{ internalLink : CKEDITOR.TRISTATE_OFF };
				});
		}
	},

} );

