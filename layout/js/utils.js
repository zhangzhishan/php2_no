/**
 * ���ֳ�����js������ɵĶ���
 * @returns {Utils}
 *
 * @time 2015-07-05
 */
function Utils() {
	
	/**
	 * �������¹���
	 * @param id string Ԫ��Id
	 * @param fast Int �ٶ� time 200 ����Ϊ��λ
	 * @returns void
	 */
	this.scrollUp = function(id, fast) {
		var element = document.getElementById(id);
		var height = element.offsetHeight;
		setInterval(function() {
			element.scrollTop++;
			if (element.scrollTop == height) {
				element.scrollTop = 0;
			}
		}, fast);
	}
	
	
	/**
	 * ʵ��jquery��$.trim()���� ȥ���ַ�����ǰ��ո�
	 * @param str string �ַ���        
	 * @returns string
	 */
	this.trim = function (str){
		return str.replace(/(^\s+)|(\s+$)/g,'');
	}
	
	/**
	 * add class����
	 * @param id string Ԫ��Id
	 * @param addClassName string Ҫadd ��class����
	 * @returns void
	 */
	this.addClass = function (id,addClassName) {
		var element = document.getElementById(id);
		if('className' in element){
			element.className += ' '+addClassName;
		}else {
			var str = element.getAttribute('class');
			
			if(str == undefined || str == null) {
				str = addClassName;
			}else {
				str += ' '+addClassName;
			}
			element.setAttribute('class',str);
		}
	
	}
	
	/**
	 * �ж��Ƿ���class
	 * @param id string Ԫ��Id
	 * @param name string className
	 * @returns void
	 */
	this.hasClass = function (id,name) {
		var element = document.getElementById(id);
		var str = element.className;
		eval("var pattern = /\\b"+name+"\\b/i");
		return pattern.test(str);		
	}
	
	/**
	 * �Ƴ�class����
	 * @param id string Ԫ��Id
	 * @param name string className
	 * @returns void
	 */
	this.removeClass = function (id,name) {
		var element = document.getElementById(id);
		var str = element.className;
		var regex = new RegExp("\\b"+name+"\\b",'ig');
		str = str.replace(regex,'');
		element.className = str;
	}
	
	/**
	 * ������Ԫ�� ����//��һ������ֹͣ����
	 * @param element ��Ҫ���ҵ�Ԫ�ض����ڴ�Ԫ�ز�����Ԫ��
	 * @param attributeName ������
	 * @param value ����ֵ
	 * @returns object element
	 * Utils.findByAttribute(ele,'value','1');  ele.value = 1
	 */
	this.findByAttribute = function (element,attributeName,value) {
		var children = element.childNodes;
		for(var i= 0;i<children.length;i++) {
			if(children[i].nodeType == 1) {
				if(children[i].getAttribute(attributeName) == value) {
					return children[i];
				}
			}
		}
	}

	/**
	 *������Ԫ��
	 *@param parentObj ���ڵ�
	 *@param tagName �ӽڵ�tagName ����input p div
	 */
	 this.findChildsByName = function (parentObj,tagName) {
		var children  = parentObj.childNodes;
		var data = new Array();
		for(var i=0;i<children.length;i++) {
			if(children[i].nodeName == tagName.toUpperCase()) {
				data.push(children[i]);
			}
		}
		return data;
	 }

	/**
	 *js��ֹð��
	 *@event ���� event�涨�����ܸ���
	 *
     */
	 this.stopBubble = function (event) {
		if(window.event) {   //IE
			window.event.cancelBubble = true;
		}else{ //firefox
			event.stopPropagation();
		}
	 }

	 /**
	  *�󶨺���
	  *@param objҪ�󶨺����Ķ���
	  *@param fun_type ���¼� click,change,select ��
	  *@param callback �ص�����
	  */
	  this.bindFunction = function (obj,fun_type,callback) {
			if(obj.addEventListener) {  //firefox
				obj.addEventListener(fun_type,callback,false);
			}else if(obj.attachEvent) {   //IE
				obj.attachEvent('on'+fun_type,callback);
			}
	  }

	/**
	 *��ȡ�ֵܽڵ�
	 *@param obj object 
	 */
	 this.get_brothers = function (obj) {
		var parent_node = obj.parentNode;
		var children = parent_node.childNodes;
		var brothers = new Array();
		for(var i=0;i<children.length;i++) {
			if(children[i] != obj && children[i].nodeType == 1) {
				brothers.push(children[i]);
			}
		}
		return brothers;
	}

	/**
	 *�жϸ��ڵ��Ƿ����ĳ���ӽڵ�
	 *
	 */
	 this.hasChildObj = function (parentObj,childObj) {
		var childs = parentObj.childNodes;
		for(var i=0;i<childs.length;i++) {
			if(childs[i] == childObj) {
				return true;
			}
		}
		
		return false;
	 }

	 /**
	  *ȫѡ/��ѡ
	  *@param id <input type="checkbox" id="check_all" />
	  *@param name  <input type="checkbox" name="check_id" />
	  */
	  this.check_all = function (id,name) {
		var check_obj = document.getElementById(id);
		var check_ids = document.getElementsByName(name);
		for(var i=0;i<check_ids.length;i++) {
			check_ids[i].checked = check_obj.checked;
		}
	  }

	/**
	 *�ж���������
	 *
	 *
	 */
	 this.is_int = function (value) {
		var value = this.trim(value);

		//�ж��Ƿ���������
		var regex = /^\d+$/;
		return regex.test(value);
	 }

}