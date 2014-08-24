var system = require('system');
var address,address1,address2,referrer1;
var re=/\//g;
// Exit in case of wrong parameter count.
if (system.args.length !== 5) {
    console.log('Usage: scriptname targetUrl referrer type adid');
    console.log('example: $> phantomjs fake-referrer.phantom.js http://example.com http://referrer.example.com 3 sogou');
	phantom.exit();
}
 
// Set the important pieces
var targetUrl = system.args[1];
var referrer = system.args[2];
var type = system.args[3];
var adid = system.args[4];

//console.log(adid);
address1=targetUrl.replace(re,"");
referrer1=referrer.replace(re,"");
//console.log(referrer1);
var d = new Date();
var date_full = d.getFullYear()+add_zero(d.getMonth()+1)+add_zero(d.getDate());
var datapath="new_"+date_full;
//console.log(datapath);
//console.log('Going to open '+targetUrl+' with the referrer '+referrer);
 
var page = require('webpage').create();
var loadtimes=1;
var cond1=0;
//page.viewportSize = { width: 600, height: 600 };
 
// set our custom referer [sic]
page.settings.userAgent = "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/34.0.1847.137 Safari/537.36 LBBROWSER";
page.customHeaders = {
        "Referer" : referrer,
        "User-Agent" : "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/34.0.1847.137 Safari/537.36 LBBROWSER 1.1"
};

page.onError = function(msg, trace) {
    var msgStack = ['ERROR: ' + msg];
    if (trace && trace.length) {
        msgStack.push('TRACE:');
        trace.forEach(function(t) {
            msgStack.push(' -> ' + t.file + ': ' + t.line + (t.function ? ' (in function "' + t.function + '")' : ''));
        });
    }
}

page.onNavigationRequested = function(url, type, willNavigate, main) {
	loadtimes=loadtimes+1;
	console.log(page.url);
//	console.log(loadtimes);
	if( loadtimes > 3){
	    if( cond1 == 0 ){
	    	if ( type ==2 || type == 3 ) {
			window.setTimeout(function () {
				console.log(targetUrl+"\t"+page.url);
				if(type == 2){
                        		console.log(page.content);
                		}
				page.close();
                		phantom.exit();
			}, 2500);
	    	}
	   	cond1=1;
	    }
	}
}

page.onLoadFinished = function(status){
	// get the currentUrl
	var currentUrl = page.evaluate(function() {
		return document.location.href;
	});
	
	// get the referrer
	var currentReferrer = page.evaluate(function() {
		return document.referrer;
	});
	
	
//	console.log('Loading ' + currentUrl + ' finished with status: ' + status+'. document.referrer is: '+currentReferrer);
	// Only once do
	if ( page.firstLoad ) {
		page.firstLoad = false;
 
//		console.log('Injecting the Link.');
 
		// Inject and Click a Link to our target
		page.evaluate(function (href) {
			// Create and append the link
			var link = document.createElement('a');
			link.setAttribute('href', href);
			document.body.appendChild(link);
			
			// Dispatch Click Event on the link
			var evt = document.createEvent('MouseEvents');
			evt.initMouseEvent('click', true, true, window, 1, 1, 1, 1, 1, false, false, false, false, 0, link);
			link.dispatchEvent(evt);
		}, targetUrl);
	} else {
	    if ( type ==2 || type == 3 ) {
		window.setTimeout(function () {
			if( cond1 == 0 ){
				console.log(targetUrl+"\t"+page.url);
				if(type == 2){
                        		console.log(page.content);
                		}
				page.close();
                		phantom.exit();
			}
                }, 1500);
            }
//		if(currentUrl!=""){
//			address2=currentUrl.replace(re,"");
// 			if( address2 != "" && address2 != referrer1){
//				console.log(targetUrl+"\t"+currentUrl);
//				if (type == 1 || type == 4){
//					page.render(datapath+"/"+adid+".jpg");
//				}	 
//				else if(type == 2){
//					console.log(page.content);
//				}
////        			phantom.exit();
//			}
//		}
//               // phantom.exit();
	};
};

window.setTimeout(function () {
	address2=page.url.replace(re,"");
	console.log(targetUrl+"\t"+page.url);

	if(type == 2){
		console.log(page.content);
        }
	if (type == 1 || type == 4){
		page.render(datapath+"/"+adid+".jpg");
	}
	page.close();
        phantom.exit();
     }, 10000);

page.firstLoad = true;
page.open(referrer, function (status) {
        if (status !== 'success') {
            console.log('Unable to load the address!');
        } else {
	    if ( type ==2 || type == 3 ) {
		window.setTimeout(function () {
			address2=page.url.replace(re,"");
			
			console.log(targetUrl+"\t"+page.url);
			if(type == 2){
                        	console.log(page.content);
                	}
			page.close();
                	phantom.exit();
                }, 6000);
            }
	    else{
            	window.setTimeout(function () {
                	console.log(targetUrl+"\t"+page.url);
			console.log(datapath);
			if (type == 1 || type == 4){
				page.render(datapath+"/"+adid+".jpg");
			}	 
			page.close();
                	phantom.exit();
            	}, 8000);
	    }
        }
});

function add_zero(temp){
        if(temp<10)
                return "0"+temp;
        else
                return temp;
}
