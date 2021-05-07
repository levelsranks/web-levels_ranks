var url = window.location.href
var arr = url.split("/");
var result = arr[0] + "//" + arr[2]

imageDir = result + "/app/modules/module_block_snow/temp/";
sflakesMax = 20; //количесто снега
sflakesMaxActive = 30; //количество снега
svMaxX = 2; //скорость падения снежинок
svMaxY = 2; //скорость падения снежинок
ssnowStick = 1; //скапливание снега внизу: включено - 1, отключено - 0
ssnowCollect = 0;
sfollowMouse = 0;
sflakeBottom = 0;
susePNG = 1;
sflakeTypes = 5;
sflakeWidth = 15;
sflakeHeight = 15;
	 
function SnowStorm() {

  // PROPERTIES
  // ------------------

  var imagePath = imageDir ? imageDir : '/app/modules/module_block_snow/temp/'; // relative path to snow images (including trailing slash)
  var flakesMax = sflakesMax ? sflakesMax : 32;
  var flakesMaxActive = sflakesMaxActive ? sflakesMaxActive : 32;
  var vMaxX = svMaxX ? svMaxX : 2;
  var vMaxY = svMaxY ? svMaxY : 3;
  var usePNG = susePNG ? susePNG : true;
  var flakeBottom = sflakeBottom ? sflakeBottom : null;        // Integer for fixed bottom, 0 or null for "full-screen" snow effect
  var snowStick = ssnowStick ? true : false;
  var snowCollect = ssnowCollect ? ssnowCollect : false;
  var targetElement = null;      // element which snow will be appended to (document body if undefined)
  var followMouse = sfollowMouse ? sfollowMouse : false;
  var flakeTypes = sflakeTypes ? sflakeTypes : 5;
  var flakeWidth = sflakeWidth ? sflakeWidth : 15;
  var flakeHeight = sflakeHeight ? sflakeHeight : 15;

  // ------------------

  var zIndex = 999; // CSS stacking order applied to each snowflake
  var flakeLeftOffset = flakeWidth; // amount to subtract from edges of container
  var flakeRightOffset = flakeWidth; // amount to subtract from edges of container

  // --- End of user section ---

  var addEvent = function(o,evtName,evtHandler) {
    typeof(attachEvent)=='undefined'?o.addEventListener(evtName,evtHandler,false):o.attachEvent('on'+evtName,evtHandler);
  }

  var removeEvent = function(o,evtName,evtHandler) {
    typeof(attachEvent)=='undefined'?o.removeEventListener(evtName,evtHandler,false):o.detachEvent('on'+evtName,evtHandler);
  }

  var classContains = function(o,cStr) {
    return (typeof(o.className)!='undefined'?o.className.indexOf(cStr)+1:false);
  }

  var s = this;
  var storm = this;
  this.timers = [];
  this.flakes = [];
  this.disabled = false;
  this.terrain = [];
  this.active = false;

  var isIE = navigator.userAgent.match(/msie/i);
  var isIE6 = navigator.userAgent.match(/msie 6/i);
  var isOldIE = (isIE && (isIE6 || navigator.userAgent.match(/msie 5/i)));
  var isWin9X = navigator.appVersion.match(/windows 98/i);
  var isiPhone = navigator.userAgent.match(/iphone/i);
  var isBackCompatIE = (isIE && document.compatMode == 'BackCompat');
  var isOpera = navigator.userAgent.match(/opera/i);
  if (isOpera) isIE = false; // Opera (which may be sneaky, pretending to be IE by default)
  var noFixed = (isBackCompatIE || isIE6 || isiPhone);
  var screenX = null;
  var screenX2 = null;
  var screenY = null;
  var scrollY = null;
  var vRndX = null;
  var vRndY = null;
  var windOffset = 1;
  var windMultiplier = 2;
  var pngSupported = (!isIE || (isIE && !isIE6 && !isOldIE)); // IE <7 doesn't do PNG nicely without crap filters
  var docFrag = document.createDocumentFragment();
  this.oControl = null; // toggle element
  if (flakeLeftOffset == null) flakeLeftOffset = 0;
  if (flakeRightOffset == null) flakeRightOffset = 0;

  function rnd(n,min) {
    if (isNaN(min)) min = 0;
    return (Math.random()*n)+min;
  }

  this.randomizeWind = function() {
    vRndX = plusMinus(rnd(vMaxX,0.2));
    vRndY = rnd(vMaxY,0.2);
    if (this.flakes) {
      for (var i=0; i<this.flakes.length; i++) {
        if (this.flakes[i].active) this.flakes[i].setVelocities();
      }
    }
  }

  function plusMinus(n) {
    return (parseInt(rnd(2))==1?n*-1:n);
  }

  this.scrollHandler = function() {
    // "attach" snowflakes to bottom of window if no absolute bottom value was given
    scrollY = (flakeBottom?0:parseInt(window.scrollY||document.documentElement.scrollTop||document.body.scrollTop));
    if (isNaN(scrollY)) scrollY = 0; // Netscape 6 scroll fix
    if (!flakeBottom && s.flakes) {
      for (var i=0; i<s.flakes.length; i++) {
        if (s.flakes[i].active == 0) s.flakes[i].stick();
      }
    }
  }

  this.resizeHandler = function() {
    if (window.innerWidth || window.innerHeight) {
      screenX = window.innerWidth-(!isIE?16:2)-flakeRightOffset;
      screenY = (flakeBottom?flakeBottom:window.innerHeight);
    } else {
      screenX = (document.documentElement.clientWidth||document.body.clientWidth||document.body.scrollWidth)-(!isIE?8:0)-flakeRightOffset;
      screenY = flakeBottom?flakeBottom:(document.documentElement.clientHeight||document.body.clientHeight||document.body.scrollHeight);
    }
    screenX2 = parseInt(screenX/2);
  }

  this.resizeHandlerAlt = function() {
    screenX = targetElement.offsetLeft+targetElement.offsetWidth-flakeRightOffset;
    screenY = flakeBottom?flakeBottom:targetElement.offsetTop+targetElement.offsetHeight;
    screenX2 = parseInt(screenX/2);
  }

  this.freeze = function() {
    // pause animation
    if (!s.disabled) {
      s.disabled = 1;
    } else {
      return false;
    }
    for (var i=0; i<s.timers.length; i++) {
      clearInterval(s.timers[i]);
    }
  }

  this.resume = function() {
    if (s.disabled) {
       s.disabled = 0;
    } else {
      return false;
    }
    s.timerInit();
  }

  this.toggleSnow = function() {
    if (!s.flakes.length) {
      // first run
      s.start();
      s.setControlActive(true);
    } else {
      s.active = !s.active;
      if (s.active) {
        s.show();
        s.resume();
        s.setControlActive(true);
      } else {
        s.stop();
        s.freeze();
        s.setControlActive(false);
      }
    }
  }

  this.stop = function() {
    this.freeze();
    for (var i=this.flakes.length; i--;) {
      this.flakes[i].o.style.display = 'none';
    }
    removeEvent(window,'scroll',s.scrollHandler);
    removeEvent(window,'resize',s.resizeHandler);
    if (!isIE) {
      removeEvent(window,'blur',s.freeze);
      removeEvent(window,'focus',s.resume);
    }
    // removeEventHandler(window,'resize',this.resizeHandler,false);
  }

  this.show = function() {
    for (var i=this.flakes.length; i--;) {
      this.flakes[i].o.style.display = 'block';
    }
  }

  this.SnowFlake = function(parent,type,x,y) {
    var s = this;
    var storm = parent;
    this.type = type;
    this.x = x||parseInt(rnd(screenX-20));
    this.y = (!isNaN(y)?y:-rnd(screenY)-12);
    this.vX = null;
    this.vY = null;
    this.vAmpTypes = [2.0,1.0,1.25,1.0,1.5,1.75]; // "amplification" for vX/vY (based on flake size/type)
    this.vAmp = this.vAmpTypes[this.type];

    this.active = 1;
    this.o = document.createElement('img');
    this.o.style.position = 'absolute';
    this.o.style.width = flakeWidth+'px';
    this.o.style.height = flakeHeight+'px';
    this.o.style.fontSize = '1px'; // so IE keeps proper size
    this.o.style.zIndex = zIndex;
    this.o.src = imagePath+this.type+(pngSupported && usePNG?'.png':'.gif');
    docFrag.appendChild(this.o);

    this.refresh = function() {
      s.o.style.left = s.x+'px';
      s.o.style.top = s.y+'px';
    }

    this.stick = function() {
      if (noFixed || (targetElement != document.documentElement && targetElement != document.body)) {
	s.o.style.top = (screenY+scrollY-flakeHeight-storm.terrain[Math.floor(s.x)])+'px';
      } else {
        s.o.style.display = 'none';
	s.o.style.top = 'auto';
        s.o.style.bottom = '0px';
	s.o.style.position = 'fixed';
        s.o.style.display = 'block';
      }
    }

    this.vCheck = function() {
      if (s.vX>=0 && s.vX<0.2) {
        s.vX = 0.2;
      } else if (s.vX<0 && s.vX>-0.2) {
        s.vX = -0.2;
      }
      if (s.vY>=0 && s.vY<0.2) {
        s.vY = 0.2;
      }
    }

    this.move = function() {
      var vX = s.vX*windOffset;
      s.x += vX;
      s.y += (s.vY*s.vAmp);
      if (vX >= 0 && (s.x >= screenX || screenX-s.x < (flakeWidth+1))) { // X-axis scroll check
        s.x = 0;
      } else if (vX < 0 && s.x-flakeLeftOffset<0-flakeWidth) {
        s.x = screenX-flakeWidth-1; // flakeWidth;
      }
      s.refresh();
      var yDiff = screenY+scrollY-s.y-storm.terrain[Math.floor(s.x)];
      if (yDiff<flakeHeight) {
        s.active = 0;
        if (snowCollect && snowStick) {
          var height = [0.75,1.5,0.75];
          for (var i=0; i<2; i++) {
            storm.terrain[Math.floor(s.x)+i+2] += height[i];
          }
        }
        s.o.style.left = (s.x/screenX*100)+'%'; // set "relative" left (change with resize)
        if (!flakeBottom) {
	  if (snowStick) {
            s.stick();
	  } else {
	    s.recycle();
	  }
        }
      }

    }

    this.animate = function() {
      // main animation loop
      // move, check status, die etc.
      s.move();
    }

    this.setVelocities = function() {
      s.vX = vRndX+rnd(vMaxX*0.12,0.1);
      s.vY = vRndY+rnd(vMaxY*0.12,0.1);
    }

    this.recycle = function() {
      s.o.style.display = 'none';
      s.o.style.position = 'absolute';
      s.o.style.bottom = 'auto';
      s.setVelocities();
      s.vCheck();
      s.x = parseInt(rnd(screenX-flakeWidth-20));
      s.y = parseInt(rnd(screenY)*-1)-flakeHeight;
      s.o.style.left = s.x+'px';
      s.o.style.top = s.y+'px';
      s.o.style.display = 'block';
      s.active = 1;
    }

    this.recycle(); // set up x/y coords etc.
    this.refresh();

  }

  this.snow = function() {
    var active = 0;
    var used = 0;
    var waiting = 0;
    for (var i=s.flakes.length; i--;) {
      if (s.flakes[i].active == 1) {
        s.flakes[i].move();
        active++;
      } else if (s.flakes[i].active == 0) {
        used++;
      } else {
        waiting++;
      }
    }
    if (snowCollect && !waiting) { // !active && !waiting
      // create another batch of snow
      s.createSnow(flakesMaxActive,true);
    }
    if (active<flakesMaxActive) {
      with (s.flakes[parseInt(rnd(s.flakes.length))]) {
        if (!snowCollect && active == 0) {
          recycle();
        } else if (active == -1) {
          active = 1;
        }
      }
    }
  }

  this.mouseMove = function(e) {
    if (!followMouse) return true;
    var x = parseInt(e.clientX);
    if (x<screenX2) {
      windOffset = -windMultiplier+(x/screenX2*windMultiplier);
    } else {
      x -= screenX2;
      windOffset = (x/screenX2)*windMultiplier;
    }
  }

  this.createSnow = function(limit,allowInactive) {
    for (var i=0; i<limit; i++) {
      s.flakes[s.flakes.length] = new s.SnowFlake(s,parseInt(rnd(flakeTypes)));
      if (allowInactive || i>flakesMaxActive) s.flakes[s.flakes.length-1].active = -1;
    }
    targetElement.appendChild(docFrag);
  }

  this.timerInit = function() {
    s.timers = (!isWin9X?[setInterval(s.snow,20)]:[setInterval(s.snow,75),setInterval(s.snow,25)]);
  }

  this.init = function() {
    for (var i=0; i<2048; i++) {
      s.terrain[i] = 0;
    }
    s.randomizeWind();
    s.createSnow(snowCollect?flakesMaxActive:flakesMaxActive*2); // create initial batch
    addEvent(window,'resize',s.resizeHandler);
    addEvent(window,'scroll',s.scrollHandler);
    if (!isIE) {
      addEvent(window,'blur',s.freeze);
      addEvent(window,'focus',s.resume);
    }
    s.resizeHandler();
    s.scrollHandler();
    if (followMouse) {
      addEvent(document,'mousemove',s.mouseMove);
    }
    s.timerInit();
  }

  var didInit = false;

  this.start = function(bFromOnLoad) {
	if (!didInit) {
	  didInit = true;
	} else if (bFromOnLoad) {
	  // already loaded and running
	  return true;
	}
    if (typeof targetElement == 'string') {
      targetElement = document.getElementById(targetElement);
      if (!targetElement) throw new Error('Snowstorm: Unable to get targetElement');
    }
	if (!targetElement) {
	  targetElement = (!isIE?(document.documentElement?document.documentElement:document.body):document.body);
	}
    if (targetElement != document.documentElement && targetElement != document.body) s.resizeHandler = s.resizeHandlerAlt; // re-map handler to get element instead of screen dimensions
    s.resizeHandler(); // get bounding box elements
    if (screenX && screenY && !s.disabled) {
      s.init();
      s.active = true;
    }
  }

  if (document.addEventListener) {
	// safari 3.0.4 doesn't do DOMContentLoaded, maybe others - use a fallback to be safe.
	document.addEventListener('DOMContentLoaded',function(){s.start(true)},false);
    window.addEventListener('load',function(){s.start(true)},false);
  } else {
    addEvent(window,'load',function(){s.start(true)});
  }

}
snowStorm = new SnowStorm();