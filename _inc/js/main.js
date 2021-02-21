var RecaptchaOptions = { 
	theme : 'blackglass', 
	tabindex : 2
};

var Cookie = {
	set: function(name, value, seconds) {
	  if(seconds) {
	    var d = new Date();
	    d.setTime(d.getTime() + (seconds * 1000));
	    var expiry = '; expires=' + d.toGMTString();
	  }
	  else {
	    var expiry = '';
	  }	
	  var returnIt = document.cookie = name + "=" + value + expiry + "; path=/";
	  return returnIt;
	},
	get: function(name){
	  var nameEQ = name + "=";
	  var ca = document.cookie.split(';');
	  for(var i = 0; i < ca.length; i++){
	    var c = ca[i];
	    while(c.charAt(0) == ' ')
	      c = c.substring(1,c.length);
	    if(c.indexOf(nameEQ) == 0) {
	      return c.substring(nameEQ.length,c.length);
	    }
	  }
	  return null;
	},
	unset: function(name){
	  Cookie.set(name,'',-1);
	}
};

var ExpandText = Class.create({
	initialize: function(sTargets, options) {
    	if((typeof Prototype=='undefined') || (typeof Scriptaculous=='undefined')) {
    		throw("Sorry, dood. Prototype and Scriptaculous libraries are required");
    	}
    	
    	this.options = Object.extend({
    		len: 98, // length of truncated text
    		open: false, // should the text be expanded by default?
    		openMsg: '+', // messaging for a closed section
    		closeMsg: '-', // messaging for an open section
    		heightAdjust: 6,
    		allowedTags: '<b><i><em><strong><a>'   		 
    	}, options || {});
    	
    	var targets = $$(sTargets);
    	this.targetStr = sTargets;
    	for (var i = 0; i < targets.length; i++) {
    		this.truncateIt(targets[i]);
    	}
    	
    	var openers = $$('a.open-close');
  		  for(var i = 0; i < openers.length; i++) {
  		  	openers[i].observe('click', this.__Click.bindAsEventListener(this));
  		 }  	
    	
	},
	
	truncateIt: function(el) {
		// split output up into two spans: excerpt and extended... hide extended		
		var content = this.stripTags(el.innerHTML);
		//var content = el.innerHTML;
		// check that the content is is long enough to truncate 
		if (content.length > this.options.len) {
		    
		    // Truncate the content
		    var excerpt = content.substring(0, this.options.len);
		    var len = 100;
		    var regex = /(?:>[^>]*(?=[^>]*<))?[\S\s]{1,300}$/;
		    //var excerpt = content.reverse().match(regex)[0].reverse();
		    
		    var extended = content.substring(this.options.len);
		    //var extended = content.substring(actualLength);
		    
		    var indicator = " <span class='indicate closed'>[...]</span>";
		    // Create a excerpt div, insert text
		    var excerptDiv = new Element('span', {'class': 'excerpt'}).update(excerpt);
		    // Do the same for extented
		    var extendedDiv = new Element('span', {'class': 'extended', 'style': 'display:none'}).update(extended);
		    excerptDiv.addClassName('excerpt'); // insanely stupid since we've already added a classname in the Element constructor
		    extendedDiv.addClassName('extended'); // but it seems to please IE
		    // replace the content with the new divs
		    $(el).update();
		    $(el).insert(excerptDiv).insert(extendedDiv).insert(indicator);
		    var height = excerptDiv.getHeight() + this.options.heightAdjust;
		    $(el).setStyle('height:' + height + 'px');
		    
  		  }
  		  
  		  // otherwise, get rid of more/less link
  		  else {
  		  	var relatedLink = el.next('ul').down('li a.more').remove();
  		  }

	},
	
	stripTags: function(el) {
		// TODO: enable allowed tags... i.e. act more like PHP's strip_tags
		//return el.stripTags();
		return strip_tags(el, this.options.allowedTags);		
	},
	
	__Click: function(e) {
		// TODO: make this less stupid and hacky
		e.stop();
		var el = e.element();
		el.toggleClassName('active');
		
		var extend = el.up('ul').previous(this.targetStr).down('.extended');
		var ind = el.up('ul').previous(this.targetStr).down('.indicate');
		var excerpt = el.up('ul').previous(this.targetStr).down('span.excerpt');

		if(el.hasClassName('active')) {		
			el.update(this.options.closeMsg);
			extend.show();			
			ind.hide();
						
			var height = excerpt.getHeight() + extend.getHeight() + this.options.heightAdjust;
			var div = el.up('ul').previous(this.targetStr);
			var morphing = new Effect.Morph(div, {
				style: 'height:' + height + 'px',
				duration: 0.5
			});
		}
		else {
			el.update(this.options.openMsg);
			ind.show();
			var height = excerpt.getHeight() + this.options.heightAdjust;
			var div = el.up('ul').previous(this.targetStr);
			var morphing = new Effect.Morph(div, {
				style: 'height:' + height + 'px',
				duration: 0.5,
				afterFinish: function() {
					extend.hide();
				}.bind(this)
			});		
		}	
		
	}

});

var IE6Msg = Class.create({
	initialize: function() {
		var msg = "<p>Hello Internet Explorer 6 user. We're glad you're visiting, but this site will work <em>much</em> better in a newer browser. <a href='http://getfirefox.com' target='_blank'>We suggest Firefox</a>.</p>";	
		msg += "<p class='last'><a href='#' id='ie6-ignore'>Don't show this message again</a></p>";
		var div = new Element('div').update(msg);
		div.addClassName('ie6-msg');
		$('page').insert({top: div});
		$('ie6-ignore').observe('click', function(e) {
			e.stop();
			Cookie.set("hellotowerie6ignore", "true", 7889231) // about 3 months
			div.remove();
		});
	}
});

function strip_tags(str, allowed_tags) {
    // http://kevin.vanzonneveld.net
    // +   original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +   improved by: Luke Godfrey
    // +      input by: Pul
    // +   bugfixed by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +   bugfixed by: Onno Marsman
    // +      input by: Alex
    // +   bugfixed by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +      input by: Marc Palau
    // +   improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // *     example 1: strip_tags('<p>Kevin</p> <br /><b>van</b> <i>Zonneveld</i>', '<i><b>');
    // *     returns 1: 'Kevin <b>van</b> <i>Zonneveld</i>'
    // *     example 2: strip_tags('<p>Kevin <img src="someimage.png" onmouseover="someFunction()">van <i>Zonneveld</i></p>', '<p>');
    // *     returns 2: '<p>Kevin van Zonneveld</p>'
    // *     example 3: strip_tags("<a href='http://kevin.vanzonneveld.net'>Kevin van Zonneveld</a>", "<a>");
    // *     returns 3: '<a href='http://kevin.vanzonneveld.net'>Kevin van Zonneveld</a>'
    
    var key = '', tag = '', allowed = false;
    var matches = allowed_array = [];
 
    var replacer = function(search, replace, str) {
        return str.split(search).join(replace);
    };
 
    // Build allowes tags associative array
    if (allowed_tags) {
        allowed_array = allowed_tags.match(/([a-zA-Z]+)/gi);
    }
  
    str += '';
 
    // Match tags
    matches = str.match(/(<\/?[^>]+>)/gi);
 
    // Go through all HTML tags
    for (key in matches) {
        if (isNaN(key)) {
            // IE7 Hack
            continue;
        }
 
        // Save HTML tag
        html = matches[key].toString();
 
        // Is tag not in allowed list? Remove from str!
        allowed = false;
 
        // Go through all allowed tags
        for (k in allowed_array) {
            // Init
            allowed_tag = allowed_array[k];
            i = -1;
 
            if (i != 0) { i = html.toLowerCase().indexOf('<'+allowed_tag+'>');}
            if (i != 0) { i = html.toLowerCase().indexOf('<'+allowed_tag+' ');}
            if (i != 0) { i = html.toLowerCase().indexOf('</'+allowed_tag)   ;}
 
            // Determine
            if (i == 0) {
                allowed = true;
                break;
            }
        }
 
        if (!allowed) {
            str = replacer(html, "", str); // Custom replace. No regexing
        }
    }
 
    return str;
}

String.prototype.reverse = function() {
	return this.split("").reverse().join("");
};


var Lyrics = Class.create({
	
	initialize: function(sTrigger, sTarget) {
		$$(sTarget).invoke('hide');
		$$(sTrigger).invoke('update', 'Show &darr;');
		$$(sTrigger).invoke('observe', 'click', function(e) {
			var el = e.findElement();
			var cousin = el.up('tr').next('tr').down('td');
			cousin.toggle();
			if(cousin.visible()) {
				el.update('Hide &uarr;');
			}
			else {
				el.update('Show &darr;');
			}

		});		
	}
	
});



var debug = false;
document.observe('dom:loaded', function(e) {
	var expand = new ExpandText('div.press-release', {len: 300, openMsg: '[+] Read More', closeMsg: '[-] Collapse' });
	var isIE6 = false /*@cc_on || @_jscript_version < 5.7 @*/;
	var lyrics = new Lyrics('.lyrics-available', '.lyrics');
	// commenting out, can't verify that cookies work in IE6
	//if(isIE6 || debug) {
		// check cookie to see if they've already visited (and checked to ignore messages), elsewise display friendly msg
		//var cookie = Cookie.get("hellotowerie6ignore");
		//if(cookie != "true") {
			//var ie6 = new IE6Msg();
		//} 
	//}	

});