if(s2w == null) var s2w = {};
function S2W_Log(){
	this.DEBUG = false;
	this.SEP0 = "|";
	this.SEP1 = "#";
	
	this.info = function(context, m){
		console.info(this._getOutput(context,m, true));
	}
	this.error = function(context, m){
		console.error(this._getOutput(context,m, true));
	}
	this.debug = function(context, m){
		if(s2w.log.DEBUG) console.debug(this._getOutput(context,m, false));
	}
	this._getOutput = function(e,m, storage){
		k = new Date().getTime();
		v = e.toString()+this.SEP1+m;
		
		if(storage) this._storage(k,v);
		
		return k+v;
	}
	this._storage = function(k,v){
		sessionStorage.setItem("s2w.log|"+k,v);
	}
	this.clear = function(){this.info(this, 'clearing the log');
		sessionStorage.clear();
	}
}

if(s2w.log == null) s2w.log = new S2W_Log();

window.onerror = function (msg, url, line){
	s2w.log.error(this,'error event not catched: '+msg+' en '+url+' linea '+line);
	return true;
}
