!function(t){if("object"==typeof exports&&"undefined"!=typeof module)module.exports=t();else if("function"==typeof define&&define.amd)define([],t);else{var e;e="undefined"!=typeof window?window:"undefined"!=typeof global?global:"undefined"!=typeof self?self:this,e.Pjax=t()}}(function(){return function(){function t(e,o,n){function i(r,a){if(!o[r]){if(!e[r]){var l="function"==typeof require&&require;if(!a&&l)return l(r,!0);if(s)return s(r,!0);var c=Error("Cannot find module '"+r+"'");throw c.code="MODULE_NOT_FOUND",c}var u=o[r]={exports:{}};e[r][0].call(u.exports,function(t){var o=e[r][1][t];return i(o||t)},u,u.exports,t,e,o,n)}return o[r].exports}for(var s="function"==typeof require&&require,r=0;r<n.length;r++)i(n[r]);return i}return t}()({1:[function(t,e){var o=t("./lib/execute-scripts"),n=t("./lib/foreach-els"),i=t("./lib/parse-options"),s=t("./lib/switches"),r=t("./lib/uniqueid"),a=t("./lib/events/on"),l=t("./lib/events/trigger"),c=t("./lib/util/clone"),u=t("./lib/util/contains"),h=t("./lib/util/extend"),d=t("./lib/util/noop"),p=function(t){this.state={numPendingSwitches:0,href:null,options:null},this.options=i(t),this.log("Pjax options",this.options),this.options.scrollRestoration&&"scrollRestoration"in history&&(history.scrollRestoration="manual"),this.maxUid=this.lastUid=r(),this.parseDOM(document),a(window,"popstate",function(t){if(t.state){var e=c(this.options);e.url=t.state.url,e.title=t.state.title,e.history=!1,e.scrollPos=t.state.scrollPos,t.state.uid<this.lastUid?e.backward=!0:e.forward=!0,this.lastUid=t.state.uid,this.loadUrl(t.state.url,e)}}.bind(this))};if(p.switches=s,p.prototype={log:t("./lib/proto/log"),getElements:function(t){return t.querySelectorAll(this.options.elements)},parseDOM:function(e){var o=t("./lib/proto/parse-element");n(this.getElements(e),o,this)},refresh:function(t){this.parseDOM(t||document)},reload:function(){window.location.reload()},attachLink:t("./lib/proto/attach-link"),attachForm:t("./lib/proto/attach-form"),forEachSelectors:function(e,o,n){return t("./lib/foreach-selectors").bind(this)(this.options.selectors,e,o,n)},switchSelectors:function(e,o,n,i){return t("./lib/switches-selectors").bind(this)(this.options.switches,this.options.switchesOptions,e,o,n,i)},latestChance:function(t){window.location=t},onSwitch:function(){l(window,"resize scroll"),this.state.numPendingSwitches--,0===this.state.numPendingSwitches&&this.afterAllSwitches()},loadContent:function(t,e){if("string"!=typeof t)return void l(document,"pjax:complete pjax:error",e);var o=document.implementation.createHTMLDocument("pjax"),n=/<html[^>]+>/gi,i=/\s?[a-z:]+(?:=['"][^'">]+['"])*/gi,s=t.match(n);if(s&&s.length&&(s=s[0].match(i),s.length&&(s.shift(),s.forEach(function(t){var e=t.trim().split("=");1===e.length?o.documentElement.setAttribute(e[0],!0):o.documentElement.setAttribute(e[0],e[1].slice(1,-1))}))),o.documentElement.innerHTML=t,this.log("load content",o.documentElement.attributes,o.documentElement.innerHTML.length),document.activeElement&&u(document,this.options.selectors,document.activeElement))try{document.activeElement.blur()}catch(r){}this.switchSelectors(this.options.selectors,o,document,e)},abortRequest:t("./lib/abort-request"),doRequest:t("./lib/send-request"),handleResponse:t("./lib/proto/handle-response"),loadUrl:function(t,e){e="object"==typeof e?h({},this.options,e):c(this.options),this.log("load href",t,e),this.abortRequest(this.request),l(document,"pjax:send",e),this.request=this.doRequest(t,e,this.handleResponse.bind(this))},afterAllSwitches:function(){var t=Array.prototype.slice.call(document.querySelectorAll("[autofocus]")).pop();t&&document.activeElement!==t&&t.focus(),this.options.selectors.forEach(function(t){n(document.querySelectorAll(t),function(t){o(t)})});var e=this.state;if(e.options.history&&(window.history.state||(this.lastUid=this.maxUid=r(),window.history.replaceState({url:window.location.href,title:document.title,uid:this.maxUid,scrollPos:[0,0]},document.title)),this.lastUid=this.maxUid=r(),window.history.pushState({url:e.href,title:e.options.title,uid:this.maxUid,scrollPos:[0,0]},e.options.title,e.href)),this.forEachSelectors(function(t){this.parseDOM(t)},this),l(document,"pjax:complete pjax:success",e.options),"function"==typeof e.options.analytics&&e.options.analytics(),e.options.history){var i=document.createElement("a");if(i.href=this.state.href,i.hash){var s=i.hash.slice(1);s=decodeURIComponent(s);var a=0,c=document.getElementById(s)||document.getElementsByName(s)[0];if(c&&c.offsetParent)do a+=c.offsetTop,c=c.offsetParent;while(c);window.scrollTo(0,a)}else e.options.scrollTo!==!1&&(e.options.scrollTo.length>1?window.scrollTo(e.options.scrollTo[0],e.options.scrollTo[1]):window.scrollTo(0,e.options.scrollTo))}else e.options.scrollRestoration&&e.options.scrollPos&&window.scrollTo(e.options.scrollPos[0],e.options.scrollPos[1]);this.state={numPendingSwitches:0,href:null,options:null}}},p.isSupported=t("./lib/is-supported"),p.isSupported())e.exports=p;else{var f=d;for(var m in p.prototype)p.prototype.hasOwnProperty(m)&&"function"==typeof p.prototype[m]&&(f[m]=d);e.exports=f}},{"./lib/abort-request":2,"./lib/events/on":4,"./lib/events/trigger":5,"./lib/execute-scripts":6,"./lib/foreach-els":7,"./lib/foreach-selectors":8,"./lib/is-supported":9,"./lib/parse-options":10,"./lib/proto/attach-form":11,"./lib/proto/attach-link":12,"./lib/proto/handle-response":13,"./lib/proto/log":14,"./lib/proto/parse-element":15,"./lib/send-request":16,"./lib/switches":18,"./lib/switches-selectors":17,"./lib/uniqueid":19,"./lib/util/clone":20,"./lib/util/contains":21,"./lib/util/extend":22,"./lib/util/noop":23}],2:[function(t,e){var o=t("./util/noop");e.exports=function(t){t&&t.readyState<4&&(t.onreadystatechange=o,t.abort())}},{"./util/noop":23}],3:[function(t,e){e.exports=function(t){var e=t.text||t.textContent||t.innerHTML||"",o=t.src||"",n=t.parentNode||document.querySelector("head")||document.documentElement,i=document.createElement("script");if(e.match("document.write"))return console&&console.log&&console.log("Script contains document.write. Can’t be executed correctly. Code skipped ",t),!1;if(i.type="text/javascript",i.id=t.id,""!==o&&(i.src=o,i.async=!1),""!==e)try{i.appendChild(document.createTextNode(e))}catch(s){i.text=e}return n.appendChild(i),(n instanceof HTMLHeadElement||n instanceof HTMLBodyElement)&&n.contains(i)&&n.removeChild(i),!0}},{}],4:[function(t,e){var o=t("../foreach-els");e.exports=function(t,e,n,i){e="string"==typeof e?e.split(" "):e,e.forEach(function(e){o(t,function(t){t.addEventListener(e,n,i)})})}},{"../foreach-els":7}],5:[function(t,e){var o=t("../foreach-els");e.exports=function(t,e,n){e="string"==typeof e?e.split(" "):e,e.forEach(function(e){var i;i=document.createEvent("HTMLEvents"),i.initEvent(e,!0,!0),i.eventName=e,n&&Object.keys(n).forEach(function(t){i[t]=n[t]}),o(t,function(t){var e=!1;t.parentNode||t===document||t===window||(e=!0,document.body.appendChild(t)),t.dispatchEvent(i),e&&t.parentNode.removeChild(t)})})}},{"../foreach-els":7}],6:[function(t,e){var o=t("./foreach-els"),n=t("./eval-script");e.exports=function(t){"script"===t.tagName.toLowerCase()&&n(t),o(t.querySelectorAll("script"),function(t){t.type&&"text/javascript"!==t.type.toLowerCase()||(t.parentNode&&t.parentNode.removeChild(t),n(t))})}},{"./eval-script":3,"./foreach-els":7}],7:[function(t,e){e.exports=function(t,e,o){return t instanceof HTMLCollection||t instanceof NodeList||t instanceof Array?Array.prototype.forEach.call(t,e,o):e.call(o,t)}},{}],8:[function(t,e){var o=t("./foreach-els");e.exports=function(t,e,n,i){i=i||document,t.forEach(function(t){o(i.querySelectorAll(t),e,n)})}},{"./foreach-els":7}],9:[function(t,e){e.exports=function(){return window.history&&window.history.pushState&&window.history.replaceState&&!navigator.userAgent.match(/((iPod|iPhone|iPad).+\bOS\s+[1-4]\D|WebApps\/.+CFNetwork)/)}},{}],10:[function(t,e){function o(){window._gaq&&_gaq.push(["_trackPageview"]),window.ga&&ga("send","pageview",{page:location.pathname,title:document.title})}var n=t("./switches");e.exports=function(t){return t=t||{},t.elements=t.elements||"a[href], form[action]",t.selectors=t.selectors||["title",".js-Pjax"],t.switches=t.switches||{},t.switchesOptions=t.switchesOptions||{},t.history=void 0===t.history?!0:t.history,t.analytics="function"==typeof t.analytics||t.analytics===!1?t.analytics:o,t.scrollTo=void 0===t.scrollTo?0:t.scrollTo,t.scrollRestoration=void 0!==t.scrollRestoration?t.scrollRestoration:!0,t.cacheBust=void 0===t.cacheBust?!0:t.cacheBust,t.debug=t.debug||!1,t.timeout=t.timeout||0,t.currentUrlFullReload=void 0===t.currentUrlFullReload?!1:t.currentUrlFullReload,t.switches.head||(t.switches.head=n.switchElementsAlt),t.switches.body||(t.switches.body=n.switchElementsAlt),t}},{"./switches":18}],11:[function(t,e){function o(t){for(var e=[],o=t.elements,n=0;n<o.length;n++){var i=o[n],s=i.tagName.toLowerCase();if(i.name&&void 0!==i.attributes&&"button"!==s){var r=i.attributes.type;if(!r||"checkbox"!==r.value&&"radio"!==r.value||i.checked){var a=[];if("select"===s)for(var l,c=0;c<i.options.length;c++)l=i.options[c],l.selected&&!l.disabled&&a.push(l.hasAttribute("value")?l.value:l.text);else a.push(i.value);for(var u=0;u<a.length;u++)e.push({name:encodeURIComponent(i.name),value:encodeURIComponent(a[u])})}}}return e}function n(t,e){return t.protocol!==window.location.protocol||t.host!==window.location.host?"external":t.hash&&t.href.replace(t.hash,"")===window.location.href.replace(location.hash,"")?"anchor":t.href===window.location.href.split("#")[0]+"#"?"anchor-empty":e.currentUrlFullReload&&t.href===window.location.href.split("#")[0]?"reload":void 0}var i=t("../events/on"),s=t("../util/clone"),r="data-pjax-state",a=function(t,e){if(!l(e)){var i=s(this.options);i.requestOptions={requestUrl:t.getAttribute("action")||window.location.href,requestMethod:t.getAttribute("method")||"GET"};var a=document.createElement("a");a.setAttribute("href",i.requestOptions.requestUrl);var c=n(a,i);if(c)return void t.setAttribute(r,c);e.preventDefault(),"multipart/form-data"===t.enctype?i.requestOptions.formData=new FormData(t):i.requestOptions.requestParams=o(t),t.setAttribute(r,"submit"),i.triggerElement=t,this.loadUrl(a.href,i)}},l=function(t){return t.defaultPrevented||t.returnValue===!1};e.exports=function(t){var e=this;t.setAttribute(r,""),i(t,"submit",function(o){a.call(e,t,o)})}},{"../events/on":4,"../util/clone":20}],12:[function(t,e){function o(t,e){return e.which>1||e.metaKey||e.ctrlKey||e.shiftKey||e.altKey?"modifier":t.protocol!==window.location.protocol||t.host!==window.location.host?"external":t.hash&&t.href.replace(t.hash,"")===window.location.href.replace(location.hash,"")?"anchor":t.href===window.location.href.split("#")[0]+"#"?"anchor-empty":void 0}var n=t("../events/on"),i=t("../util/clone"),s="data-pjax-state",r=function(t,e){if(!a(e)){var n=i(this.options),r=o(t,e);if(r)return void t.setAttribute(s,r);if(e.preventDefault(),this.options.currentUrlFullReload&&t.href===window.location.href.split("#")[0])return t.setAttribute(s,"reload"),void this.reload();t.setAttribute(s,"load"),n.triggerElement=t,this.loadUrl(t.href,n)}},a=function(t){return t.defaultPrevented||t.returnValue===!1};e.exports=function(t){var e=this;t.setAttribute(s,""),n(t,"click",function(o){r.call(e,t,o)}),n(t,"keyup",function(o){13===o.keyCode&&r.call(e,t,o)}.bind(this))}},{"../events/on":4,"../util/clone":20}],13:[function(t,e){var o=t("../util/clone"),n=t("../uniqueid"),i=t("../events/trigger");e.exports=function(t,e,s,r){if(r=o(r||this.options),r.request=e,t===!1)return void i(document,"pjax:complete pjax:error",r);var a=window.history.state||{};window.history.replaceState({url:a.url||window.location.href,title:a.title||document.title,uid:a.uid||n(),scrollPos:[document.documentElement.scrollLeft||document.body.scrollLeft,document.documentElement.scrollTop||document.body.scrollTop]},document.title,window.location.href);var l=s;e.responseURL?s!==e.responseURL&&(s=e.responseURL):e.getResponseHeader("X-PJAX-URL")?s=e.getResponseHeader("X-PJAX-URL"):e.getResponseHeader("X-XHR-Redirected-To")&&(s=e.getResponseHeader("X-XHR-Redirected-To"));var c=document.createElement("a");c.href=l;var u=c.hash;c.href=s,u&&!c.hash&&(c.hash=u,s=c.href),this.state.href=s,this.state.options=r;try{this.loadContent(t,r)}catch(h){if(i(document,"pjax:error",r),this.options.debug)throw h;return console&&console.error&&console.error("Pjax switch fail: ",h),this.latestChance(s)}}},{"../events/trigger":5,"../uniqueid":19,"../util/clone":20}],14:[function(t,e){e.exports=function(){this.options.debug&&console&&("function"==typeof console.log?console.log.apply(console,arguments):console.log&&console.log(arguments))}},{}],15:[function(t,e){var o="data-pjax-state";e.exports=function(t){switch(t.tagName.toLowerCase()){case"a":t.hasAttribute(o)||this.attachLink(t);break;case"form":t.hasAttribute(o)||this.attachForm(t);break;default:throw"Pjax can only be applied on <a> or <form> submit"}}},{}],16:[function(t,e){var o=t("./util/update-query-string");e.exports=function(t,e,n){e=e||{};var i,s=e.requestOptions||{},r=(s.requestMethod||"GET").toUpperCase(),a=s.requestParams||null,l=s.formData||null,c=null,u=new XMLHttpRequest,h=e.timeout||0;if(u.onreadystatechange=function(){4===u.readyState&&(200===u.status?n(u.responseText,u,t,e):0!==u.status&&n(null,u,t,e))},u.onerror=function(o){console.log(o),n(null,u,t,e)},u.ontimeout=function(){n(null,u,t,e)},a&&a.length)switch(i=a.map(function(t){return t.name+"="+t.value}).join("&"),r){case"GET":t=t.split("?")[0],t+="?"+i;break;case"POST":c=i}else l&&(c=l);return e.cacheBust&&(t=o(t,"t",Date.now())),u.open(r,t,!0),u.timeout=h,u.setRequestHeader("X-Requested-With","XMLHttpRequest"),u.setRequestHeader("X-PJAX","true"),u.setRequestHeader("X-PJAX-Selectors",JSON.stringify(e.selectors)),c&&"POST"===r&&!l&&u.setRequestHeader("Content-Type","application/x-www-form-urlencoded"),u.send(c),u}},{"./util/update-query-string":24}],17:[function(t,e){var o=t("./foreach-els"),n=t("./switches");e.exports=function(t,e,i,s,r,a){var l=[];i.forEach(function(i){var c=s.querySelectorAll(i),u=r.querySelectorAll(i);if(this.log&&this.log("Pjax switch",i,c,u),c.length!==u.length)throw"DOM doesn’t look the same on new loaded page: ’"+i+"’ - new "+c.length+", old "+u.length;o(c,function(o,s){var r=u[s];this.log&&this.log("newEl",o,"oldEl",r);var c=t[i]?t[i].bind(this,r,o,a,e[i]):n.outerHTML.bind(this,r,o,a);l.push(c)},this)},this),this.state.numPendingSwitches=l.length,l.forEach(function(t){t()})}},{"./foreach-els":7,"./switches":18}],18:[function(t,e){var o=t("./events/on");e.exports={outerHTML:function(t,e){t.outerHTML=e.outerHTML,this.onSwitch()},innerHTML:function(t,e){t.innerHTML=e.innerHTML,""===e.className?t.removeAttribute("class"):t.className=e.className,this.onSwitch()},switchElementsAlt:function(t,e){if(t.innerHTML=e.innerHTML,e.hasAttributes())for(var o=e.attributes,n=0;n<o.length;n++)t.attributes.setNamedItem(o[n].cloneNode());this.onSwitch()},replaceNode:function(t,e){t.parentNode.replaceChild(e,t),this.onSwitch()},sideBySide:function(t,e,n,i){var s=Array.prototype.forEach,r=[],a=[],l=document.createDocumentFragment(),c="animationend webkitAnimationEnd MSAnimationEnd oanimationend",u=0,h=function(t){t.target===t.currentTarget&&(u--,0>=u&&r&&(r.forEach(function(t){t.parentNode&&t.parentNode.removeChild(t)}),a.forEach(function(t){t.className=t.className.replace(t.getAttribute("data-pjax-classes"),""),t.removeAttribute("data-pjax-classes")}),a=null,r=null,this.onSwitch()))}.bind(this);i=i||{},s.call(t.childNodes,function(t){r.push(t),t.classList&&!t.classList.contains("js-Pjax-remove")&&(t.hasAttribute("data-pjax-classes")&&(t.className=t.className.replace(t.getAttribute("data-pjax-classes"),""),t.removeAttribute("data-pjax-classes")),t.classList.add("js-Pjax-remove"),i.callbacks&&i.callbacks.removeElement&&i.callbacks.removeElement(t),i.classNames&&(t.className+=" "+i.classNames.remove+" "+(n.backward?i.classNames.backward:i.classNames.forward)),u++,o(t,c,h,!0))}),s.call(e.childNodes,function(t){if(t.classList){var e="";i.classNames&&(e=" js-Pjax-add "+i.classNames.add+" "+(n.backward?i.classNames.forward:i.classNames.backward)),i.callbacks&&i.callbacks.addElement&&i.callbacks.addElement(t),t.className+=e,t.setAttribute("data-pjax-classes",e),a.push(t),l.appendChild(t),u++,o(t,c,h,!0)}}),t.className=e.className,t.appendChild(l)}}},{"./events/on":4}],19:[function(t,e){e.exports=function(){var t=0;return function(){var e="pjax"+(new Date).getTime()+"_"+t;return t++,e}}()},{}],20:[function(t,e){e.exports=function(t){if(null===t||"object"!=typeof t)return t;var e=t.constructor();for(var o in t)t.hasOwnProperty(o)&&(e[o]=t[o]);return e}},{}],21:[function(t,e){e.exports=function(t,e,o){for(var n=0;n<e.length;n++)for(var i=t.querySelectorAll(e[n]),s=0;s<i.length;s++)if(i[s].contains(o))return!0;return!1}},{}],22:[function(t,e){e.exports=function(t){if(null==t)return null;for(var e=Object(t),o=1;o<arguments.length;o++){var n=arguments[o];if(null!=n)for(var i in n)Object.prototype.hasOwnProperty.call(n,i)&&(e[i]=n[i])}return e}},{}],23:[function(t,e){e.exports=function(){}},{}],24:[function(t,e){e.exports=function(t,e,o){var n=RegExp("([?&])"+e+"=.*?(&|$)","i"),i=-1!==t.indexOf("?")?"&":"?";return t.match(n)?t.replace(n,"$1"+e+"="+o+"$2"):t+i+e+"="+o}},{}]},{},[1])(1)});


(function(doc, _) {
    let root = doc.documentElement,
        innerHTML = Pjax.switches.innerHTML;
    new Pjax({
        elements: 'a[href]:not([target]),form[action]:not([target])',
        selectors: ['body>div>main', 'body>div>nav', 'body>svg', 'title'],
        switches: {
            'body>div>main': innerHTML,
            'body>div>nav': innerHTML,
            'body>svg': innerHTML,
            'title': function(before, after) {
                before.outerHTML = after.outerHTML;
                root.className = after.parentNode.parentNode.className;
                this.onSwitch();
            }
        },
        cacheBust: false
    });
    function onChange() {
        let formSubmitButtons = doc.querySelectorAll('form[action] [name][value][type=submit]'),
            clones = {};
        formSubmitButtons.forEach(function(button) {
            let name = button.name, input;
            function onClick() {
                clones[this.name] && (clones[this.name].value = this.value);
            }
            button.addEventListener('touchstart', onClick, false);
            button.addEventListener('mousedown', onClick, false);
            button.addEventListener('click', onClick, false);
            if (clones[name]) {
                return;
            }
            input = doc.createElement('input');
            input.type = 'hidden';
            input.name = name;
            input.value = button.value;
            clones[name] = input;
            button.parentNode.appendChild(input);
        });
    } onChange();
    _.on('change', onChange);
    doc.addEventListener('pjax:send', function() {
        _.fire('let');
    }, false);
    doc.addEventListener('pjax:success', function() {
        _.fire('change');
    }, false);
})(this.document, this._);
