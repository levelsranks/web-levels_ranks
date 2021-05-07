$(document).ready(function(){
	$(document).on('input','[name="promocode"],[name="amount"],[name="steam"]',function(){
	var promocode=$('[name="promocode"]'),
		amount=$('[name="amount"]'),
		steam=$('[name="steam"]');

	if(promocode.val() && $.isNumeric(amount.val()) && steam.val()){

		$.ajax({
				type:'POST',
				url: window.location.href, 
				data:'promocode='+promocode.val()+'&amount='+amount.val()+'&steamid='+steam.val(),
				cache:false,
			success:function(result){
				if(result.trim()){
					result=jQuery.parseJSON(result.trim());
					if(result.result){
						$('#promoresult').html(result.result);
					}else{
						$('#promoresult').html(false);}
					}
				}
			});
	}else{
		$('#promoresult').html(false);
	}
});
	$(document).on('input','[name="steam"]',function(){
	var steam=$('[name="steam"]');

	if(steam.val()){

		$.ajax({
				type:'POST',
				url: window.location.href, 
				data:'steamidload='+steam.val(),
				cache:false,
			success:function(result){
				if(result.trim()){
					result=jQuery.parseJSON(result.trim());
					if(result.img){
						$('#profile').html('<img class="badge" width="64" src="'+result.img+'"><br><small>'+result.name+'</small>');
					}else{
						$('#profile').html(false);}
					}
				}
			});
	}else{
		$('#profile').html(false);
	}
});
	$('form').submit(function(event){
		if($(this).attr('data-default'))
		{
			var del = $(this).attr('data-get');
			event.preventDefault();
			var mess;
			$.ajax({
				type: $(this).attr('method'),
				url: window.location.href,
				data: new FormData(this),
				contentType: false,
				cache: false,
				processData: false,
				success: function(result){
					mess = jQuery.parseJSON(result.trim());
					if(mess.status)
					{
						if(mess.status == 'success')
						{
							setTimeout(function(){
						
								if(del){
									removeParam(del);
								}else{
									window.location.reload();
								}
							}, 4100);
						}
							note({
							  content: mess.text,
							  type: mess.status,
							  time: 4
							});
					}
					else if(mess.location)
					{	
						window.location.href = mess.location;
					}
					else 
					{
						$('#resultForm').html(mess.text);
						document.getElementById('punsh').click();
					}
				}
			});
		}
	});

        document.addEventListener("click", removeElem("col-md-6", "data-del", "delete"));
	});

	function removeElem(delElem, attribute, attributeName) {
	  if (!(delElem && attribute && attributeName)) return;
	  return function(e) {
	    let target = e.target;
	    if (!(target.hasAttribute(attribute) ?
	        (target.getAttribute(attribute) === attributeName ? true : false) : false)) return;
	    	removeParam(target.getAttribute('data-get'));
	    let elem = target;
	    while (target != this) {
	      if (target.classList.contains(delElem)) {
	        target.remove();
	        return;
	      }
	      target = target.parentNode;
	    }
	    return;
	  };
	}

	function removeParam(key) {
	  var splitUrl = window.location.href.split('?'),
	    rtn = splitUrl[0],
	    param,
	    params_arr = [],
	    queryString = (window.location.href.indexOf("?") !== -1) ? splitUrl[1] : '';
	  if (queryString !== '') {
	    params_arr = queryString.split('&');
	    for (var i = params_arr.length - 1; i >= 0; i -= 1) {
	      param = params_arr[i].split('=')[0];
	      if (param === key) {
	        params_arr.splice(i, 1);
	      }
	    }
	    rtn = rtn + '?' + params_arr.join('&');
	  }
	  window.location.href = rtn;
	}
!function(d) {

  "use strict";

  Object.assign||Object.defineProperty(Object,"assign",{enumerable:!1,configurable:!0,writable:!0,value:function(e,r){"use strict";if(null==e)throw new TypeError("Cannot convert first argument to object");for(var t=Object(e),n=1;n<arguments.length;n++){var o=arguments[n];if(null!=o)for(var a=Object.keys(Object(o)),c=0,b=a.length;c<b;c++){var i=a[c],l=Object.getOwnPropertyDescriptor(o,i);void 0!==l&&l.enumerable&&(t[i]=o[i])}}return t}});

  "remove" in Element.prototype||(Element.prototype.remove=function(){this.parentNode&&this.parentNode.removeChild(this)});

  window.note = function(settings) {

    settings = Object.assign({},{
      callback:    false,
      content:     "",
      time:        4.5,
      type:        "info"
    }, settings);

    if(!settings.content.length) return;

    var create = function(name, attr, append, content) {
      var node = d.createElement(name);
      for(var val in attr) { if(attr.hasOwnProperty(val)) node.setAttribute(val, attr[val]); }
      if(content) node.insertAdjacentHTML("afterbegin", content);
      append.appendChild(node);
      if(node.classList.contains("note-item-hidden")) node.classList.remove("note-item-hidden");
      return node;
    };

    var noteBox = d.getElementById("notes") || create("div", { "id": "notes" }, d.body);
    var noteItem = create("div", {
        "class": "note-item",
        "data-show": "false",
        "role": "alert",
        "data-type": settings.type
      }, noteBox),
      noteItemText = create("div", { "class": "note-item-text" }, noteItem, settings.content),
      noteItemBtn = create("button", {
        "class": "note-item-btn",
        "type": "button",
      }, noteItem);

    var isVisible = function() {
      var coords = noteItem.getBoundingClientRect();
      return (
        coords.top >= 0 &&
        coords.left >= 0 &&
        coords.bottom <= (window.innerHeight || d.documentElement.clientHeight) && 
        coords.right <= (window.innerWidth || d.documentElement.clientWidth) 
      );
    };
   
    var remove = function(el) {
      el = el || noteItem;
      el.setAttribute("data-show","false");
      window.setTimeout(function() {
        el.remove();
      }, 250);
      if(settings.callback) settings.callback(); // callback
    };

    noteItemBtn.addEventListener("click", function() { remove(); });

    window.setTimeout(function() {
      noteItem.setAttribute("data-show","true");
      PlaySound('storage/assets/sounds/'+settings.type+'.mp3');
    }, 250);

    if(!isVisible()) remove(noteBox.firstChild);

    window.setTimeout(remove, settings.time * 1000);

  };

}(document);