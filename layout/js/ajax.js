/**
 * ���Ǹ����������ͬ��ajax����ʽ
 * @author by wq
 * @time by 2015-12-12
 */
var HTTP = {};
HTTP._factories = [
     function() { return new XMLHttpRequest();},  //�󲿷ֵ��������֧�� IE7,8 firefox
     function() { return new ActiveObject("Msxml2.XMLHTTP");},    //IE5,IE6
     function() { return new ActiveXObject("Microsoft.XMLHTTP");}   
];

HTTP._factory = null;

HTTP.newRequest = function() {
	if(HTTP._factory != null) {
		return HTTP._factory();
	}
	
	for(var i=0;i<HTTP._factories.length;i++){
		try{
			var factory = HTTP._factories[i];
			var request = factory();
			if(request != null){
				HTTP._factory = factory;
				return request;
			}
		}catch(e){
			continue;
		}
	}
	
	HTTP._factory = function() {
		throw new Error("XMLHttpRequest not supported.");
	}
	HTTP._factory();
};

/**
 * get��������ֵ
 * @param url 
 * @param callback �ص����� 
 * HTTP.get('www.baidu.com','test') ���� HTTP.get('www.baidu.com',test) ���߶���
 */
HTTP.get = function(url,callback){
	try{
		var request = HTTP.newRequest();
		request.open("GET",url,true);  //�첽
		request.send(null);
		
		request.onreadystatechange = function() {   //�첽��������дonreadystatechange
			if(request.status == 200 && request.readyState == 4) {
				var data = request.responseText;
				if(callback != null) {
				
					if(typeof callback == 'function') {
						callback(data);
					}else if(typeof callback == 'string') {
						eval(callback+'("'+data+'")');
					}
					
				}
			}
		}
	}catch(e) {
		
	}
};

/**
 * post��ֵ
 * @param values ���� {'a':1,'b':2}
 * @param callback �ص�����
 * 
 */
HTTP.post = function (url,values,callback) {
	var request = HTTP.newRequest();
	request.open("POST",url);
	request.setRequestHeader("Content-Type","application/x-www-form-urlencoded");  //������Ҫ ����postֵ��
	
	request.send(HTTP.encodeFormData(values));
	
	var json = arguments[3]?arguments[3]:0;

	request.onreadystatechange = function(){ 
		if(request.status == 200 && request.readyState == 4) {
			var data = request.responseText;
			if(json == 'json') {
				data = eval('('+data+')');
			}

			if(callback != null){
				if(typeof callback == 'function') {
					callback(data);
				}else if(typeof callback == 'string'){
					eval(callback+'("'+data+'")');
				}
			}
		}
	}
}

/**
 * ��url����
 * @param data ����
 */
HTTP.encodeFormData = function(data) {
	var pairs = [];
	var regexp = /%20/g; 
	
	for(var name in data) {
		var value = data[name].toString();
		var pair = encodeURIComponent(name).replace(regexp,"+")+ '='+encodeURIComponent(value).replace(regexp,"+");
		pairs.push(pair);
	}
	return pairs.join('&');
}
