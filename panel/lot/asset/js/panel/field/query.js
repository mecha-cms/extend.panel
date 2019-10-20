/*!
 * =======================================================
 *  SIMPLEST TAGS INPUT BEAUTIFIER 2.2.5
 * =======================================================
 *
 *   Author: Taufik Nurrohman
 *   URL: https://github.com/tovic
 *   License: MIT
 *
 * -- USAGE: ---------------------------------------------
 *
 *   var tags = new TIB(document.querySelector('input'));
 *
 * -------------------------------------------------------
 *
 */
!function(e,t,n){function r(e){return t.createElement(e)}function a(e){return Object.keys(e)}function i(e){return a(e).length}var s="__instance__",o=setTimeout,f="innerHTML",u="textContent",l="class",c=l+"Name",p=l+"es",g="toLowerCase",d="replace",v="pattern",h="placeholder",m="indexOf",k="firstChild",y="parentNode",l="Sibling",b="next"+l,w="previous"+l,j="appendChild",x="insertBefore",C="removeChild",l="Attribute",E="set"+l,L="get"+l,D="preventDefault",_="addEventListener",N="removeEventListener",T="scrollLeft";!function(e){e.version="2.2.5",e[s]={},e.each=function(t,n){return o(function(){var n,r=e[s];for(n in r)t(r[n],n,r)},0===n?0:n||1),e}}(e[n]=function(t,l){function B(){M.focus()}function K(e){var t,n=e?this:M;o(function(){t=n[u].split(J.join);for(P in t)z.set(t[P])},1)}function O(){z.error=0,z.set(this[u])}function R(e){z.error=0;var t,n=this,r=e.keyCode,a=Q,i=J.escape,s=(e.key||String.fromCharCode(r))[g](),l=e.ctrlKey,c=e.shiftKey,p=J.step,d=U[w]&&U[w][L](V),v=M[b],h="tab"===s||!c&&9===r,k="enter"===s||!c&&13===r,j=" "===s||!c&&32===r,x="backspace"===s||!c&&8===r,C=""===n[u];if(!l&&k&&-1===i[m]("\n")){for(;a=a[y];)if("form"===a.nodeName[g]()){t=a,e[D]();break}z.set(n[u]),0===z.error&&t&&t.submit()}else if(!C||l||"arrowleft"!==s&&(c||37!==r))if(!C||l||"arrowright"!==s&&(c||39!==r))if(l&&("v"===s||!c&&86===r))K();else if(C&&x)z.reset(d),B(),e[D]();else{var E,_;for(P in i)if(E=i[P],_="s"===E,(_||"	"===E)&&h||(_||"\n"===E)&&k||(_||" "===E)&&j)return o(function(){z.set(n[u]),B()},1),void e[D]();o(function(){var e=n[u];for(v[f]=e?"​":G,P=0,$=i.length;$>P;++P)if(i[P]&&-1!==e[m](i[P])){z.set(e.split(i[P]).join(""));break}},1)}else Q[T]+=p;else Q[T]-=p}function S(){M[f]="",M[b][f]=G}function q(e){return t[c]=W+" "+J[p][3],Q[c]=J[p][0]+" "+J[p][0]+"-"+F,Q.id=J[p][0]+":"+(t.id||F),Q[f]='<span class="'+J[p][4]+'"></span>',U[c]=J[p][1]+" "+J[p][2],U[f]='<span contenteditable spellcheck="false" style="white-space:nowrap;outline:none;"></span><span>'+G+"</span>",t[y][x](Q,t[b]||null),Q[k][j](U),M=U[k],Q[_]("click",B,!1),t[_]("focus",B,!1),M[_]("blur",O,!1),M[_]("paste",K,!1),M[_]("keydown",R,!1),z.update(t.value.split(J.join),e),z}function A(){t[c]=W,Q[y][C](Q),Q[N]("click",B),t[N]("focus",B),M[N]("blur",O),M[N]("paste",K),M[N]("keydown",R)}var H,I,M,P,$,z=this,F=Date.now(),G=(t[L]("data-"+h)||t[h]||"")+"​",J={join:", ",max:9999,step:5,escape:[","],alert:!0,text:["Delete “%{tag}%”","Duplicate “%{tag}%”","Please match the requested format: %{pattern}%"],classes:["tags","tag","tags-input","tags-output","tags-view"],update:function(){}},Q=r("span"),U=r("span"),V="data-tag";e[n][s][t.id||t.name||i(e[n][s])]=z,l="string"==typeof l?{join:l}:l||{};for(P in l)J[P]=l[P];I=J[v]||t[L]("data-"+v),H=J.update,J[h]&&(G=J[h]+"​"),z.tags={},z.error=0,z.filter=function(e){return I?!e||RegExp(I).test(e)?e:!1:(e+"")[d](RegExp("["+J.join[d](/\s/g,"")+"]|[-\\s]{2,}|^\\s+|\\s+$","g"),"")[g]()},z.update=function(e,n){for(t.value="";(P=Q[k][k])&&P[L](V);)Q[k][C](P);if(0===e)e=a(z.tags);else{for(P in e)$=z.filter(e[P]),$&&(z.tags[$]=1);e=a(z.tags)}z.tags={};for(P in e)z.set(e[P],n);return H.call(z,z.tags),z},z.reset=function(e){return e=z.filter(e||""),e?delete z.tags[e]:z.tags={},z.update(0,1)},z.set=function(e,n){var s,o=J.alert,f=J.text;if(e=z.filter(e),e===!1)return S(),o&&(z.error=2,s=(f[2]||e)[d](/%\{pattern\}%/g,I),"function"==typeof o?o.call(z,s,e):alert(s)),z;if(""===e||i(z.tags)>=J.max)return S(),z;var u,l=r("span"),g=r("a");return l[c]=J[p][1],l[E](V,e),g.href="javascript:;",g.title=(f[0]||"")[d](/%\{tag\}%/g,e),g[_]("click",function(e){var t=this,n=t[y],r=t[y][L](V);n[y][C](n),z.reset(r),B(),e[D]()},!1),l[j](g),S(),(u=z.tags[e])?n?Q[k][x](l,U):o&&(z.error=1,s=(f[1]||e)[d](/%\{tag\}%/g,e),"function"==typeof o?o.call(z,s,u):alert(s)):(z.tags[e]=l,Q[k][x](l,U)),t.value=a(z.tags).join(J.join),!n&&H.call(z,z.tags),z};var W=t[c];q.call(z,1),z.create=function(){return q.call(z,1)},z.destroy=function(){return A.call(z)},z.config=J,z.input=U,z.self=Q,z.source=z.output=t})}(window,document,"TIB");

(function(doc) {
    var query = doc.querySelectorAll('.field\\:query .input'), $$, c;
    if (query.length) {
        query.forEach(function($) {
            c = $.className;
            $$ = new TIB($, {max: 10});
            $$.self.className += ' ' + c;
        });
    }
})(document);