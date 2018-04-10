/**
 * @license Copyright (c) 2003-2015, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function (config) {
    // Define changes to default configuration here. For example:
    // config.language = 'fr';
    // config.uiColor = '#AADC6E';
    config.toolbarCanCollapse = true;

    config.toolbar = [
        { name: 'document', items : [ 'Source','-','Save','NewPage','DocProps','Preview','Print','-','Templates' ] },
	{ name: 'clipboard', items : [ 'Cut','Copy','Paste','PasteText','PasteFromWord','-','Undo','Redo' ] },
	{ name: 'editing', items : [ 'Find','Replace','-','SelectAll','-','SpellChecker', 'Scayt' ] },
	{ name: 'forms', items : [ 'Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 
        'HiddenField' ] },
	'/',
	{ name: 'basicstyles', items : [ 'Bold','Italic','Underline','Strike','Subscript','Superscript','-','RemoveFormat' ] },
	{ name: 'paragraph', items : [ 'NumberedList','BulletedList','-','Outdent','Indent','-','Blockquote','CreateDiv',
	'-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock','-','BidiLtr','BidiRtl' ] },
	{ name: 'links', items : [ 'Link','Unlink','Anchor' ] },
	{ name: 'insert', items : [ 'Image','Flash','Table','HorizontalRule','Smiley','SpecialChar','PageBreak','Iframe' ] },
	'/',
	{ name: 'styles', items : [ 'Styles','Format','Font','FontSize' ] },
	{ name: 'colors', items : [ 'TextColor','BGColor' ] },
	{ name: 'tools', items : [ 'Maximize', 'ShowBlocks','-','About' ] },
        {name: 'ckwebspeech', items: ['webSpeechEnabled', 'webSpeechSettings' ]},
        {name: 'uploadimage', items: ['filebrowserUploadUrl']}
    ];
    
    
    config.extraPlugins = 'ckwebspeech,uploadimage';
    
    config.saveUrl = '/saveImage';
    //config.saveUrl = 'http://localhost:8000/saveImage';
    //config.pollUrl = 'https://localhost:3000/socket.io';
    //config.pollUrl = '/autoSave';
    
    /*Todo: make url dynamic to where the project is deployed in*/
    //For file uploads, specifically image uploads
    config.filebrowserImageUploadUrl = 'https://job.tc/saveImage';
    //config.filebrowserImageUploadUrl = 'http://localhost:8000/saveImage';
    
    //For ckwebspeechs
    config.ckwebspeech = {'culture': 'en',
        'commandvoice': 'command', //trigger voice commands
        'commands': [//command list
            {'newline': 'new line'}, //trigger to add a new line in CKEditor
            {'newparagraph': 'new paragraph'}, //trigger to add a new paragraph in CKEditor
            {'undo': 'undo'}, //trigger to undo changes in CKEditor
            {'redo': 'redo'} //trigger to redo changes in CKEditor
        ]
    };
    
    //Theme changes
    config.skin = 'office2013';
    //config.uiColor = '#F3F4F5';
    
    
    //Css changes
    config.height = '200px';

    //config.autoParagraph = false;
    config.removePlugins = 'autosave';

};
