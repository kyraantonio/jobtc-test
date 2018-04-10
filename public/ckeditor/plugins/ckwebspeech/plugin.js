var langs =
[['Afrikaans',       ['af-ZA']],
 ['Bahasa Indonesia',['id-ID']],
 ['Bahasa Melayu',   ['ms-MY']],
 ['Català',          ['ca-ES']],
 ['Čeština',         ['cs-CZ']],
 ['Deutsch',         ['de-DE']],
 ['English',         ['en-AU', 'Australia'],
                     ['en-CA', 'Canada'],
                     ['en-IN', 'India'],
                     ['en-NZ', 'New Zealand'],
                     ['en-ZA', 'South Africa'],
                     ['en-GB', 'United Kingdom'],
                     ['en-US', 'United States']],
 ['Español',         ['es-AR', 'Argentina'],
                     ['es-BO', 'Bolivia'],
                     ['es-CL', 'Chile'],
                     ['es-CO', 'Colombia'],
                     ['es-CR', 'Costa Rica'],
                     ['es-EC', 'Ecuador'],
                     ['es-SV', 'El Salvador'],
                     ['es-ES', 'España'],
                     ['es-US', 'Estados Unidos'],
                     ['es-GT', 'Guatemala'],
                     ['es-HN', 'Honduras'],
                     ['es-MX', 'México'],
                     ['es-NI', 'Nicaragua'],
                     ['es-PA', 'Panamá'],
                     ['es-PY', 'Paraguay'],
                     ['es-PE', 'Perú'],
                     ['es-PR', 'Puerto Rico'],
                     ['es-DO', 'República Dominicana'],
                     ['es-UY', 'Uruguay'],
                     ['es-VE', 'Venezuela']],
 ['Euskara',         ['eu-ES']],
 ['Français',        ['fr-FR']],
 ['Galego',          ['gl-ES']],
 ['Hrvatski',        ['hr_HR']],
 ['IsiZulu',         ['zu-ZA']],
 ['Íslenska',        ['is-IS']],
 ['Italiano',        ['it-IT', 'Italia'],
                     ['it-CH', 'Svizzera']],
 ['Magyar',          ['hu-HU']],
 ['Nederlands',      ['nl-NL']],
 ['Norsk bokmål',    ['nb-NO']],
 ['Polski',          ['pl-PL']],
 ['Português',       ['pt-BR', 'Brasil'],
                     ['pt-PT', 'Portugal']],
 ['Română',          ['ro-RO']],
 ['Slovenčina',      ['sk-SK']],
 ['Suomi',           ['fi-FI']],
 ['Svenska',         ['sv-SE']],
 ['Türkçe',          ['tr-TR']],
 ['български',       ['bg-BG']],
 ['Pусский',         ['ru-RU']],
 ['Српски',          ['sr-RS']],
 ['한국어',            ['ko-KR']],
 ['中文',             ['cmn-Hans-CN', '普通话 (中国大陆)'],
                     ['cmn-Hans-HK', '普通话 (香港)'],
                     ['cmn-Hant-TW', '中文 (台灣)'],
                     ['yue-Hant-HK', '粵語 (香港)']],
 ['日本語',           ['ja-JP']],
 ['Lingua latīna',   ['la']]];

var CKWebSpeechCommandVoice = function(editor)
{
	this._editor = editor;
	this._commandvoice = false;
	this._commands = false;
	this._regexpcommand = false;

	this.CKWebSpeechCommandVoice(this._editor.config);
}

CKWebSpeechCommandVoice.prototype.CKWebSpeechCommandVoice = function(config)
{
	if(typeof this._editor.config.ckwebspeech == 'undefined')
		this._editor.config['ckwebspeech'] = {};

	this.setCommands(this._editor.config);
}

CKWebSpeechCommandVoice.prototype.setCommands = function(config) {
	var command = false;
	var commands = false;
	
	if(config.ckwebspeech.commandvoice)
		command =  config.ckwebspeech.commandvoice;

	if(config.ckwebspeech.commands)
		commands = this.makeCommands(config.ckwebspeech.commands);
	

	if(command && commands)
	{
		this._regexpcommand = new RegExp('(' + command + '){1}\\s{1}(' + commands + ')','gi')
		this._commands = config.ckwebspeech.commands;
		this._commandvoice = command;
	}
}

CKWebSpeechCommandVoice.prototype.makeCommands = function(commands) {
	var strCommands = '';
	
	if(commands instanceof Array)
	{
		for (var i = 0; i < commands.length; i++) {
			var cmd = commands[i];
			strCommands += this.makeValidCommand(cmd);
		}
		return strCommands == ''? false: strCommands.replace(/\|$/gi, '');
	}
	else
		return false;
	

}

CKWebSpeechCommandVoice.prototype.makeValidCommand = function(cmd)
{
	var validCommands = new RegExp("(newline|newparagraph|undo|redo)");
	if(typeof cmd == 'object')
	{
		for(var index in cmd)
		{
			if(validCommands.test(index))
				return cmd[index] + '|';
		}	
	}
	return '';
}

CKWebSpeechCommandVoice.prototype.buildResult = function(result) {

	if(this._regexpcommand)
	{
		var executeCmds ;
		var cmdVals = [];
		while((executeCmds = this._regexpcommand.exec(result)) != null)
			cmdVals.push(executeCmds[2])
		
		for (var i = 0; i < cmdVals.length; i++) {
			
			var cmdVal = new String(cmdVals[i]);
			var cmd = this.getCommandForResult(cmdVal);
			result = this.execCmd(cmd, cmdVal, result);
		}
		return result;
	}
	else
		return result;
}

CKWebSpeechCommandVoice.prototype.execCmd = function(cmd, cmdVal, result)
{
	var replace = new RegExp(this._commandvoice + ' ' + cmdVal + '\\s?', 'gi');
	switch(cmd)
	{
		case 'newline':
			return result.replace(replace, '\n');
		case 'newparagraph':
			return result.replace(replace, '\n\n');
		case 'undo':
			this._editor.execCommand( 'undo' );
			return false;
		case 'redo':
			this._editor.execCommand( 'redo' )
			return false;
		default:
		 return result;
	}
}

CKWebSpeechCommandVoice.prototype.getCommandForResult = function(cmdVal)
{
	this._commands
	for (var i = 0; i < this._commands.length; i++) {
		for(var index in this._commands[i])
		{
			if (this._commands[i][index] == cmdVal) 
			{
				return index;
			}
		}
	}
	return '';
}

var CKWebSpeechHandler = function(editor)
{
	CKWebSpeechCommandVoice.call(this, editor);

	this._currentCulture = {val: 'en-US', langVal: 6};
	this._elmtPlugIcon;
	this._plugPath;
	this._recognizing;
	this._recognition;
	this._ignoreOnend;
	this._start_timestamp;
	this._working;

	this.CKWebSpeechHandler();
}
CKWebSpeechHandler.prototype = Object.create(CKWebSpeechCommandVoice.prototype);

CKWebSpeechHandler.prototype.CKWebSpeechHandler = function()
{

	this._recognition;
	this._plugPath = this._editor.plugins.ckwebspeech.path;
	this._recognizing = false;
	this._ignoreOnend = false;
	this._working = false;

	this.getElementPluginIcon();
	this.initServiceSpeech();
}

CKWebSpeechHandler.prototype.isUnlockedService = function()
{
	if (!('webkitSpeechRecognition' in window)) 
		return false;  
	return true;
}
CKWebSpeechHandler.prototype.getElementPluginIcon = function()
{
	var obj = this; var cont =0;

	var listener = setInterval(function(){
		cont++;
		var element;
		try
			{element = document.getElementById(obj._editor.ui.instances.webSpeechEnabled._.id);}
		catch(err)
			{element = null;}
		
		if(element !== null)
		{
			obj._elmtPlugIcon = element.getElementsByClassName('cke_button__webspeechenabled_icon')[0];
			clearInterval(listener);
		}
		if(cont == 500) clearInterval(listener);
	}, 1);
}

CKWebSpeechHandler.prototype.updateIcons = function()
{
	if(this._recognizing){
		this._editor.ui.get("webSpeechEnabled").label = "Disable";
		this._editor.ui.get("webSpeechEnabled").icon = this._plugPath 
			+ 'icons/webspeech.png';
		this._elmtPlugIcon.style.backgroundImage = 'url(' + this._plugPath 
			+ 'icons/webspeech-enable.gif)';
		
	}else{
		this._editor.ui.get("webSpeechEnabled").label = "Enable";
		this._editor.ui.get("webSpeechEnabled").icon = this._plugPath 
			+ 'icons/webspeech-enable.gif';
		this._elmtPlugIcon.style.backgroundImage = 'url(' +  this._plugPath 
			+ 'icons/webspeech.png)';
	}
}

CKWebSpeechHandler.prototype.initServiceSpeech = function()
{
	if(this.isUnlockedService())
	{
		this._recognition = new webkitSpeechRecognition();
		this._recognition.continuous = true; 
		this._recognition.interimResults = true;
		
		var self = this
		this._recognition.onstart = function(){ self.onStart() };
		this._recognition.onerror = function(event){ self.onError(event) };
		this._recognition.onend = function(){ self.onEnd() };
		this._recognition.onresult = function(event){ self.onResult(event) };
		this._recognition.onspeechstart = function(event){self.onSpeech()};
		this._recognition.onspeechend = function(event){self.onSpeechEnd()};
	}
}

CKWebSpeechHandler.prototype.onStart = function()
{
	this._recognizing = true;
    this.updateIcons();
}

CKWebSpeechHandler.prototype.onError = function(event)
{
	if (event.error == 'no-speech') {
      //start_img.src = '/media/images-webspeech/mic.gif
      //console.log('info_no_speech');
      this._ignore_onend = true;
    }
    if (event.error == 'audio-capture') {
      //start_img.src = '/media/images-webspeech/mic.gif';
      //showInfo('info_no_microphone');
      //console.log('auddio_capture');
      this._ignore_onend = true;
    }
    if (event.error == 'not-allowed') {
      if (event.timeStamp - this._start_timestamp < 100) {
        //console.log('info_blocked');//showInfo('info_blocked');
      } else {
        //console.log('info_denied');//showInfo('info_denied');
      }
      this._ignore_onend = true;
    }
    this.updateIcons();
}

CKWebSpeechHandler.prototype.onEnd = function()
{
	this._recognizing = false;
    if (this._ignoreOnend) return;
    
    this.updateIcons();
    
}
CKWebSpeechHandler.prototype.onSpeech = function(event)
{
	this._elmtPlugIcon.style.backgroundImage = 'url(' +  this._plugPath 
			+ 'icons/speech.gif)';
}

CKWebSpeechHandler.prototype.onSpeechEnd = function(event)
{
	this.updateIcons();
}

CKWebSpeechHandler.prototype.onResult = function(event)
{

    if (typeof(event.results) == 'undefined') {
    	this._recognizing = false;
	    this._recognition.onend = null;
	    this._recognition.stop();
	    this.updateIcons();
      //upgrade();
    	return;
    }
    this._elmtPlugIcon.style.backgroundImage = 'url(' +  this._plugPath 
			+ 'icons/speech.gif)';
    for (var i = event.resultIndex; i < event.results.length; ++i) {
    	
        if (event.results[i].isFinal) {
        	var result = this.buildResult(event.results[i][0].transcript);
        	if(result)
          		this._editor.insertText(result);
          this.updateIcons();
        }
      }
}

CKWebSpeechHandler.prototype.toogleSpeech = function()
{
	if(!this._recognizing)
		{
			this._recognition.lang = this._currentCulture.val;
			this._recognition.start();
			this._ignore_onend = false;
			this._start_timestamp = new Date().getTime();
		}
	else
		{this._recognition.stop();}
	

}


var CKWebSpeech = function(editor){
	CKWebSpeechHandler.call(this, editor);
	this._langs = langs;

	this.CKWebSpeech();
	
	}

CKWebSpeech.prototype = Object.create( CKWebSpeechHandler.prototype );

CKWebSpeech.prototype.CKWebSpeech = function(){
	if(typeof this._editor.config.ckwebspeech == 'undefined')
		this._editor.config['ckwebspeech'] = {};	
	

	if(this._editor.config.ckwebspeech.culture)
		this.setDialectByCulture(this._editor.config.ckwebspeech.culture);
}

CKWebSpeech.prototype.setDialectByCulture = function(_culture)
{
	for (var i = 0; i < this._langs.length; i++) {
		for (var j = 1; j < this._langs[i].length; j++) {
			if(this._langs[i][j][0].toLowerCase() == _culture.toLowerCase())
			{
				this._currentCulture ={val: this._langs[i][j][0], langVal: i};
				return this._currentCulture;
			}//FALTA COLOCAR EN COOKIE
		};
	};
	return this._currentCulture;
}

CKWebSpeech.prototype.setDialectByLanguage = function(_langVal)
{
	this.setDialectByCulture(this._langs[_langVal][1][0]);
}

CKWebSpeech.prototype.getLanguages = function()
{
	var _languages = new Array();
	for (var i = 0; i < this._langs.length; i++) {
		_languages.push(new Array(this._langs[i][0], i));
	};
	return _languages;
}

CKWebSpeech.prototype.getCultures = function(_langVal)
{

	if(typeof _langVal === "undefined")
		_langVal = this._currentCulture.langVal;

	var _cultures = new Array();
	for (var i = 1; i < this._langs[_langVal].length; i++) {
		_cultures.push( new Array(this._langs[_langVal][i][0]));
	};
	return  _cultures;
}

CKEDITOR.plugins.add( 'ckwebspeech', {
    icons: 'webspeech',
    init: function( editor ) {

			editor['ckWebSpeech'] = new CKWebSpeech(editor);
    		var pathPlugin = this.path;

	    	editor.addCommand( 'webspeechDialog', new CKEDITOR.dialogCommand( 'webspeechDialog' ) );
	    	editor.addCommand('webspeechToogle', {
				exec: function( editor ) {
					editor.ckWebSpeech.toogleSpeech();
				}
			});

			editor.ui.addButton( 'webSpeechEnabled',
			{
				label : 'Enable',
				icon : pathPlugin + 'icons/webspeech.png',
				command : 'webspeechToogle',
				toolbar : 'ckwebspeech'
			});
			editor.ui.addButton( 'webSpeechSettings',
			{
				label : 'Settings',
				icon : pathPlugin + 'icons/webspeech-settings.png',
				command : 'webspeechDialog',
				toolbar : 'ckwebspeech'
			});
		
        CKEDITOR.dialog.add( 'webspeechDialog', this.path + 'dialogs/ckwebspeech.js' );
    }
});