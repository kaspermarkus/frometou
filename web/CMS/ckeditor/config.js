/*
Copyright (c) 2003-2011, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/

CKEDITOR.editorConfig = function( config )
{
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
	config.toolbar = 'CustomToolbar';
 
       config.toolbar_MyToolbar =
               [
               ['Save','-',],
               ['Cut','Copy','Paste','PasteFromWord','-', 'Scayt'],
               ['Undo','Redo','-','Find','Replace','-','RemoveFormat','-','Source'],
               '/',
               ['Bold','Italic','Underline','Strike','-'],
               ['TextColor','BGColor'],
               ['NumberedList','BulletedList','-','Outdent','Indent','Blockquote'],
               ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
               ['Link','Unlink'],
               ['Image','Table','HorizontalRule','SpecialChar'],
               '/',
               ['Format','Font','FontSize'],
               ['Maximize']
                       ];
 
       config.toolbar_CustomToolbar =
               [
               ['Save','-',],
               ['Cut','Copy','Paste','PasteFromWord','-', 'Scayt'],
               ['Undo','Redo','-','Find','Replace','-','RemoveFormat','-','Source'],
               '/',
               ['Bold','Italic','Underline','Strike','-'],
               ['TextColor','BGColor'],
               ['NumberedList','BulletedList','-','Outdent','Indent','Blockquote'],
               ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
               ['InternalLink','Link','Unlink'],
               ['Image','Table','HorizontalRule','SpecialChar'],
               '/',
               ['Format','Font','FontSize'],
               ['Maximize']
                       ];

};
