(function(global,$){if(typeof $==='undefined'){throwError('Pagination requires jQuery.')}
var pluginName='pagination';var pluginHookMethod='addHook';var eventPrefix='__pagination-';if($.fn.pagination){pluginName='pagination2'}
$.fn[pluginName]=function(options){if(typeof options==='undefined'){return this}
var container=$(this);var pagination={initialize:function(){var self=this;if(!container.data('pagination')){container.data('pagination',{})}
if(self.callHook('beforeInit')===!1)return;if(container.data('pagination').initialized){$('.paginationjs',container).remove()}
self.disabled=!!attributes.disabled;var model=self.model={pageRange:attributes.pageRange,pageSize:attributes.pageSize};self.parseDataSource(attributes.dataSource,function(dataSource){self.sync=Helpers.isArray(dataSource);if(self.sync){model.totalNumber=attributes.totalNumber=dataSource.length}
model.totalPage=self.getTotalPage();if(attributes.hideWhenLessThanOnePage){if(model.totalPage<=1)return}
var el=self.render(!0);if(attributes.className){el.addClass(attributes.className)}
model.el=el;container[attributes.position==='bottom'?'append':'prepend'](el);self.observer();container.data('pagination').initialized=!0;self.callHook('afterInit',el)})},render:function(isBoot){var self=this;var model=self.model;var el=model.el||$('<div class="paginationjs"></div>');var isForced=isBoot!==!0;self.callHook('beforeRender',isForced);var currentPage=model.pageNumber||attributes.pageNumber;var pageRange=attributes.pageRange;var totalPage=model.totalPage;var rangeStart=currentPage-pageRange;var rangeEnd=currentPage+pageRange;if(rangeEnd>totalPage){rangeEnd=totalPage;rangeStart=totalPage-pageRange*2;rangeStart=rangeStart<1?1:rangeStart}
if(rangeStart<=1){rangeStart=1;rangeEnd=Math.min(pageRange*2+1,totalPage)}
el.html(self.createTemplate({currentPage:currentPage,pageRange:pageRange,totalPage:totalPage,rangeStart:rangeStart,rangeEnd:rangeEnd}));self.callHook('afterRender',isForced);return el},createTemplate:function(args){var self=this;var currentPage=args.currentPage;var totalPage=args.totalPage;var rangeStart=args.rangeStart;var rangeEnd=args.rangeEnd;var totalNumber=attributes.totalNumber;var showPrevious=attributes.showPrevious;var showNext=attributes.showNext;var showPageNumbers=attributes.showPageNumbers;var showNavigator=attributes.showNavigator;var showGoInput=attributes.showGoInput;var showGoButton=attributes.showGoButton;var pageLink=attributes.pageLink;var prevText=attributes.prevText;var nextText=attributes.nextText;var ellipsisText=attributes.ellipsisText;var goButtonText=attributes.goButtonText;var classPrefix=attributes.classPrefix;var activeClassName=attributes.activeClassName;var disableClassName=attributes.disableClassName;var ulClassName=attributes.ulClassName;var formatNavigator=$.isFunction(attributes.formatNavigator)?attributes.formatNavigator():attributes.formatNavigator;var formatGoInput=$.isFunction(attributes.formatGoInput)?attributes.formatGoInput():attributes.formatGoInput;var formatGoButton=$.isFunction(attributes.formatGoButton)?attributes.formatGoButton():attributes.formatGoButton;var autoHidePrevious=$.isFunction(attributes.autoHidePrevious)?attributes.autoHidePrevious():attributes.autoHidePrevious;var autoHideNext=$.isFunction(attributes.autoHideNext)?attributes.autoHideNext():attributes.autoHideNext;var header=$.isFunction(attributes.header)?attributes.header():attributes.header;var footer=$.isFunction(attributes.footer)?attributes.footer():attributes.footer;var html='';var goInput='<input type="text" class="J-paginationjs-go-pagenumber">';var goButton='<input type="button" class="J-paginationjs-go-button" value="'+goButtonText+'">';var formattedString;var i;if(header){formattedString=self.replaceVariables(header,{currentPage:currentPage,totalPage:totalPage,totalNumber:totalNumber});html+=formattedString}
if(showPrevious||showPageNumbers||showNext){html+='<div class="paginationjs-pages">';if(ulClassName){html+='<ul class="'+ulClassName+'">'}
else{html+='<ul>'}
if(showPrevious){if(currentPage===1){if(!autoHidePrevious){html+='<li class="'+classPrefix+'-prev '+disableClassName+'"><a>'+prevText+'<\/a><\/li>'}}
else{html+='<li class="'+classPrefix+'-prev J-paginationjs-previous" data-num="'+(currentPage-1)+'" title="Previous page"><a href="'+pageLink+'">'+prevText+'<\/a><\/li>'}}
if(showPageNumbers){if(rangeStart<=3){for(i=1;i<rangeStart;i++){if(i==currentPage){html+='<li class="'+classPrefix+'-page J-paginationjs-page '+activeClassName+'" data-num="'+i+'"><a>'+i+'<\/a><\/li>'}
else{html+='<li class="'+classPrefix+'-page J-paginationjs-page" data-num="'+i+'"><a href="'+pageLink+'">'+i+'<\/a><\/li>'}}}
else{if(attributes.showFirstOnEllipsisShow){html+='<li class="'+classPrefix+'-page '+classPrefix+'-first J-paginationjs-page" data-num="1"><a href="'+pageLink+'">1<\/a><\/li>'}
html+='<li class="'+classPrefix+'-ellipsis '+disableClassName+'"><a>'+ellipsisText+'<\/a><\/li>'}
for(i=rangeStart;i<=rangeEnd;i++){if(i==currentPage){html+='<li class="'+classPrefix+'-page J-paginationjs-page '+activeClassName+'" data-num="'+i+'"><a>'+i+'<\/a><\/li>'}
else{html+='<li class="'+classPrefix+'-page J-paginationjs-page" data-num="'+i+'"><a href="'+pageLink+'">'+i+'<\/a><\/li>'}}
if(rangeEnd>=totalPage-2){for(i=rangeEnd+1;i<=totalPage;i++){html+='<li class="'+classPrefix+'-page J-paginationjs-page" data-num="'+i+'"><a href="'+pageLink+'">'+i+'<\/a><\/li>'}}
else{html+='<li class="'+classPrefix+'-ellipsis '+disableClassName+'"><a>'+ellipsisText+'<\/a><\/li>';if(attributes.showLastOnEllipsisShow){html+='<li class="'+classPrefix+'-page '+classPrefix+'-last J-paginationjs-page" data-num="'+totalPage+'"><a href="'+pageLink+'">'+totalPage+'<\/a><\/li>'}}}
if(showNext){if(currentPage==totalPage){if(!autoHideNext){html+='<li class="'+classPrefix+'-next '+disableClassName+'"><a>'+nextText+'<\/a><\/li>'}}
else{html+='<li class="'+classPrefix+'-next J-paginationjs-next" data-num="'+(currentPage+1)+'" title="Next page"><a href="'+pageLink+'">'+nextText+'<\/a><\/li>'}}
html+='<\/ul><\/div>'}
if(showNavigator){if(formatNavigator){formattedString=self.replaceVariables(formatNavigator,{currentPage:currentPage,totalPage:totalPage,totalNumber:totalNumber});html+='<div class="'+classPrefix+'-nav J-paginationjs-nav">'+formattedString+'<\/div>'}}
if(showGoInput){if(formatGoInput){formattedString=self.replaceVariables(formatGoInput,{currentPage:currentPage,totalPage:totalPage,totalNumber:totalNumber,input:goInput});html+='<div class="'+classPrefix+'-go-input">'+formattedString+'</div>'}}
if(showGoButton){if(formatGoButton){formattedString=self.replaceVariables(formatGoButton,{currentPage:currentPage,totalPage:totalPage,totalNumber:totalNumber,button:goButton});html+='<div class="'+classPrefix+'-go-button">'+formattedString+'</div>'}}
if(footer){formattedString=self.replaceVariables(footer,{currentPage:currentPage,totalPage:totalPage,totalNumber:totalNumber});html+=formattedString}
return html},go:function(number,callback){var self=this;var model=self.model;if(self.disabled)return;var pageNumber=number;var pageSize=attributes.pageSize;var totalPage=model.totalPage;pageNumber=parseInt(pageNumber);if(!pageNumber||pageNumber<1||pageNumber>totalPage)return;if(self.sync){render(self.getDataSegment(pageNumber));return}
var postData={};var alias=attributes.alias||{};postData[alias.pageSize?alias.pageSize:'pageSize']=pageSize;postData[alias.pageNumber?alias.pageNumber:'pageNumber']=pageNumber;var formatAjaxParams={type:'get',cache:!1,data:{},contentType:'application/x-www-form-urlencoded; charset=UTF-8',dataType:'json',async:!0};$.extend(!0,formatAjaxParams,attributes.ajax);$.extend(formatAjaxParams.data||{},postData);formatAjaxParams.url=attributes.dataSource;formatAjaxParams.success=function(response){render(self.filterDataByLocator(response))};formatAjaxParams.error=function(jqXHR,textStatus,errorThrown){attributes.formatAjaxError&&attributes.formatAjaxError(jqXHR,textStatus,errorThrown);self.enable()};self.disable();$.ajax(formatAjaxParams);function render(data){if(self.callHook('beforePaging',pageNumber)===!1)return!1;model.direction=typeof model.pageNumber==='undefined'?0:(pageNumber>model.pageNumber?1:-1);model.pageNumber=pageNumber;self.render();if(self.disabled&&!self.sync){self.enable()}
container.data('pagination').model=model;if($.isFunction(attributes.formatResult)){var cloneData=$.extend(!0,[],data);if(!Helpers.isArray(data=attributes.formatResult(cloneData))){data=cloneData}}
container.data('pagination').currentPageData=data;self.doCallback(data,callback);self.callHook('afterPaging',pageNumber);if(pageNumber==1){self.callHook('afterIsFirstPage')}
if(pageNumber==model.totalPage){self.callHook('afterIsLastPage')}}},doCallback:function(data,customCallback){var self=this;var model=self.model;if($.isFunction(customCallback)){customCallback(data,model)}
else if($.isFunction(attributes.callback)){attributes.callback(data,model)}},destroy:function(){if(this.callHook('beforeDestroy')===!1)return;this.model.el.remove();container.off();$('#paginationjs-style').remove();this.callHook('afterDestroy')},previous:function(callback){this.go(this.model.pageNumber-1,callback)},next:function(callback){this.go(this.model.pageNumber+1,callback)},disable:function(){var self=this;var source=self.sync?'sync':'async';if(self.callHook('beforeDisable',source)===!1)return;self.disabled=!0;self.model.disabled=!0;self.callHook('afterDisable',source)},enable:function(){var self=this;var source=self.sync?'sync':'async';if(self.callHook('beforeEnable',source)===!1)return;self.disabled=!1;self.model.disabled=!1;self.callHook('afterEnable',source)},refresh:function(callback){this.go(this.model.pageNumber,callback)},show:function(){var self=this;if(self.model.el.is(':visible'))return;self.model.el.show()},hide:function(){var self=this;if(!self.model.el.is(':visible'))return;self.model.el.hide()},replaceVariables:function(template,variables){var formattedString;for(var key in variables){var value=variables[key];var regexp=new RegExp('<%=\\s*'+key+'\\s*%>','img');formattedString=(formattedString||template).replace(regexp,value)}
return formattedString},getDataSegment:function(number){var pageSize=attributes.pageSize;var dataSource=attributes.dataSource;var totalNumber=attributes.totalNumber;var start=pageSize*(number-1)+1;var end=Math.min(number*pageSize,totalNumber);return dataSource.slice(start-1,end)},getTotalPage:function(){return Math.ceil(attributes.totalNumber/attributes.pageSize)},getLocator:function(locator){var result;if(typeof locator==='string'){result=locator}
else if($.isFunction(locator)){result=locator()}
else{throwError('"locator" is incorrect. (String | Function)')}
return result},filterDataByLocator:function(dataSource){var locator=this.getLocator(attributes.locator);var filteredData;if(Helpers.isObject(dataSource)){try{$.each(locator.split('.'),function(index,item){filteredData=(filteredData?filteredData:dataSource)[item]})}
catch(e){}
if(!filteredData){throwError('dataSource.'+locator+' is undefined.')}
else if(!Helpers.isArray(filteredData)){throwError('dataSource.'+locator+' must be an Array.')}}
return filteredData||dataSource},parseDataSource:function(dataSource,callback){var self=this;var args=arguments;if(Helpers.isObject(dataSource)){callback(attributes.dataSource=self.filterDataByLocator(dataSource))}
else if(Helpers.isArray(dataSource)){callback(attributes.dataSource=dataSource)}
else if($.isFunction(dataSource)){attributes.dataSource(function(data){if($.isFunction(data)){throwError('Unexpect parameter of the "done" Function.')}
args.callee.call(self,data,callback)})}
else if(typeof dataSource==='string'){if(/^https?|file:/.test(dataSource)){attributes.ajaxDataType='jsonp'}
callback(dataSource)}
else{throwError('Unexpect data type of the "dataSource".')}},callHook:function(hook){var paginationData=container.data('pagination');var result;var args=Array.prototype.slice.apply(arguments);args.shift();if(attributes[hook]&&$.isFunction(attributes[hook])){if(attributes[hook].apply(global,args)===!1){result=!1}}
if(paginationData.hooks&&paginationData.hooks[hook]){$.each(paginationData.hooks[hook],function(index,item){if(item.apply(global,args)===!1){result=!1}})}
return result!==!1},observer:function(){var self=this;var el=self.model.el;container.on(eventPrefix+'go',function(event,pageNumber,done){pageNumber=parseInt($.trim(pageNumber));if(!pageNumber)return;if(!$.isNumeric(pageNumber)){throwError('"pageNumber" is incorrect. (Number)')}
self.go(pageNumber,done)});el.delegate('.J-paginationjs-page','click',function(event){var current=$(event.currentTarget);var pageNumber=$.trim(current.attr('data-num'));if(!pageNumber||current.hasClass(attributes.disableClassName)||current.hasClass(attributes.activeClassName))return;if(self.callHook('beforePageOnClick',event,pageNumber)===!1)return!1;self.go(pageNumber);self.callHook('afterPageOnClick',event,pageNumber);if(!attributes.pageLink)return!1});el.delegate('.J-paginationjs-previous','click',function(event){var current=$(event.currentTarget);var pageNumber=$.trim(current.attr('data-num'));if(!pageNumber||current.hasClass(attributes.disableClassName))return;if(self.callHook('beforePreviousOnClick',event,pageNumber)===!1)return!1;self.go(pageNumber);self.callHook('afterPreviousOnClick',event,pageNumber);if(!attributes.pageLink)return!1});el.delegate('.J-paginationjs-next','click',function(event){var current=$(event.currentTarget);var pageNumber=$.trim(current.attr('data-num'));if(!pageNumber||current.hasClass(attributes.disableClassName))return;if(self.callHook('beforeNextOnClick',event,pageNumber)===!1)return!1;self.go(pageNumber);self.callHook('afterNextOnClick',event,pageNumber);if(!attributes.pageLink)return!1});el.delegate('.J-paginationjs-go-button','click',function(){var pageNumber=$('.J-paginationjs-go-pagenumber',el).val();if(self.callHook('beforeGoButtonOnClick',event,pageNumber)===!1)return!1;container.trigger(eventPrefix+'go',pageNumber);self.callHook('afterGoButtonOnClick',event,pageNumber)});el.delegate('.J-paginationjs-go-pagenumber','keyup',function(event){if(event.which===13){var pageNumber=$(event.currentTarget).val();if(self.callHook('beforeGoInputOnEnter',event,pageNumber)===!1)return!1;container.trigger(eventPrefix+'go',pageNumber);$('.J-paginationjs-go-pagenumber',el).focus();self.callHook('afterGoInputOnEnter',event,pageNumber)}});container.on(eventPrefix+'previous',function(event,done){self.previous(done)});container.on(eventPrefix+'next',function(event,done){self.next(done)});container.on(eventPrefix+'disable',function(){self.disable()});container.on(eventPrefix+'enable',function(){self.enable()});container.on(eventPrefix+'refresh',function(event,done){self.refresh(done)});container.on(eventPrefix+'show',function(){self.show()});container.on(eventPrefix+'hide',function(){self.hide()});container.on(eventPrefix+'destroy',function(){self.destroy()});if(attributes.triggerPagingOnInit){container.trigger(eventPrefix+'go',Math.min(attributes.pageNumber,self.model.totalPage))}}};if(container.data('pagination')&&container.data('pagination').initialized===!0){if($.isNumeric(options)){container.trigger.call(this,eventPrefix+'go',options,arguments[1]);return this}
else if(typeof options==='string'){var args=Array.prototype.slice.apply(arguments);args[0]=eventPrefix+args[0];switch(options){case 'previous':case 'next':case 'go':case 'disable':case 'enable':case 'refresh':case 'show':case 'hide':case 'destroy':container.trigger.apply(this,args);break;case 'getSelectedPageNum':if(container.data('pagination').model){return container.data('pagination').model.pageNumber}
else{return container.data('pagination').attributes.pageNumber}
case 'getTotalPage':return container.data('pagination').model.totalPage;case 'getSelectedPageData':return container.data('pagination').currentPageData;case 'isDisabled':return container.data('pagination').model.disabled===!0;default:throwError('Pagination do not provide action: '+options)}
return this}else{uninstallPlugin(container)}}
else{if(!Helpers.isObject(options)){throwError('Illegal options')}}
var attributes=$.extend({},arguments.callee.defaults,options);parameterChecker(attributes);pagination.initialize();return this};$.fn[pluginName].defaults={totalNumber:1,pageNumber:1,pageSize:10,pageRange:2,showPrevious:!0,showNext:!0,showPageNumbers:!0,showNavigator:!1,showGoInput:!1,showGoButton:!1,pageLink:'',prevText:'&laquo;',nextText:'&raquo;',ellipsisText:'...',goButtonText:'Go',classPrefix:'paginationjs',activeClassName:'active',disableClassName:'disabled',inlineStyle:!0,formatNavigator:'<%= currentPage %> / <%= totalPage %>',formatGoInput:'<%= input %>',formatGoButton:'<%= button %>',position:'bottom',autoHidePrevious:!1,autoHideNext:!1,triggerPagingOnInit:!0,hideWhenLessThanOnePage:!1,showFirstOnEllipsisShow:!0,showLastOnEllipsisShow:!0,callback:function(){}};$.fn[pluginHookMethod]=function(hook,callback){if(arguments.length<2){throwError('Missing argument.')}
if(!$.isFunction(callback)){throwError('callback must be a function.')}
var container=$(this);var paginationData=container.data('pagination');if(!paginationData){container.data('pagination',{});paginationData=container.data('pagination')}
!paginationData.hooks&&(paginationData.hooks={});paginationData.hooks[hook]=paginationData.hooks[hook]||[];paginationData.hooks[hook].push(callback)};$[pluginName]=function(selector,options){if(arguments.length<2){throwError('Requires two parameters.')}
var container;if(typeof selector!=='string'&&selector instanceof jQuery){container=selector}
else{container=$(selector)}
if(!container.length)return;container.pagination(options);return container};var Helpers={};function throwError(content){throw new Error('Pagination: '+content)}
function parameterChecker(args){if(!args.dataSource){throwError('"dataSource" is required.')}
if(typeof args.dataSource==='string'){if(typeof args.totalNumber==='undefined'){throwError('"totalNumber" is required.')}
else if(!$.isNumeric(args.totalNumber)){throwError('"totalNumber" is incorrect. (Number)')}}
else if(Helpers.isObject(args.dataSource)){if(typeof args.locator==='undefined'){throwError('"dataSource" is an Object, please specify "locator".')}
else if(typeof args.locator!=='string'&&!$.isFunction(args.locator)){throwError(''+args.locator+' is incorrect. (String | Function)')}}}
function uninstallPlugin(target){var events=['go','previous','next','disable','enable','refresh','show','hide','destroy'];$.each(events,function(index,value){target.off(eventPrefix+value)});target.data('pagination',{});$('.paginationjs',target).remove()}
function getObjectType(object,tmp){return((tmp=typeof(object))=="object"?object==null&&"null"||Object.prototype.toString.call(object).slice(8,-1):tmp).toLowerCase()}
$.each(['Object','Array'],function(index,name){Helpers['is'+name]=function(object){return getObjectType(object)===name.toLowerCase()}});if(typeof define==='function'&&define.amd){define(function(){return $})}})(this,window.jQuery)