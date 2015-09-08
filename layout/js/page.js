/**
 *pages js
 *2015-5-5
 * by  wq
 *@param query string url ajax url
 *@param filter object search condition 
 *@param replaceDiv div ID  <div id='replaceDiv'><table></table></div> 默认为listDiv
 */
var page = {}; //
page.filter = {};

page.changePageSize = function (obj) {
	var val = obj.value;

	this.filter.page_size = val;

	this.reload();

}

/**
 *
 *
 */
page.gotoPageFirst = function () {
	if(this.filter.page == 1) {
		return ;
	}
	this.filter.page = 1;
	this.reload();
}

/**
 * 
 *
 */
page.gotoPageLast = function () {
	if(this.filter.page == this.filter.page_num) {
		return ;
	}
	this.filter.page = this.filter.page_num;
	this.reload();
}

/**
 *
 *
 */
page.gotoPagePrev = function () {
	if(this.filter.page == 1) {
		return ;
	}
	this.filter.page--;
	this.reload();
}
/**
 *First 
 *
 */
page.gotoPageNext = function () {
	if(this.filter.page == this.filter.page_num) {
		return ;
	}
	this.filter.page++;
	this.reload();
}

/**
 *
 *
 */
page.gotoPage = function(obj) {
	var val = obj.value;
	if(val > this.filter.page_num) {
		return;
	}
	this.filter.page = val;

	this.reload();
}

/**
 *
 *
 */
page.reload = function () {
	
	HTTP.post(this.query,this.filter,function(data){
		if(this.replaceDiv) {

		}else {
			document.getElementById('listDiv').innerHTML = data.content;
		}	
		
		page.filter = data.filter;

	},'json');

}