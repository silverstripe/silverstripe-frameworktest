!function(t){function e(r){if(n[r])return n[r].exports
var o=n[r]={exports:{},id:r,loaded:!1}
return t[r].call(o.exports,o,o.exports,e),o.loaded=!0,o.exports}var n={}
return e.m=t,e.c=n,e.p="",e(0)}([function(t,e,n){"use strict"
n(1)},function(t,e,n){"use strict"
function r(t){return t&&t.__esModule?t:{default:t}}var o=n(2),i=r(o),u=n(3),c=r(u),s=n(4),a=r(s),f=n(5),l=n(6),d=r(l),m="TestReactFormBuilder"
i.default.entwine("ss",function(t){t(".TestReactFormBuilder").entwine({onmatch:function t(){var e=this
setTimeout(function(){return e._renderForm()},100),this[0].style.setProperty("overflow-y","scroll","important")},onunmatch:function t(){this._clearForm(),this.css("overflow-y",!1)},open:function t(){this._renderForm()

},close:function t(){this._clearForm()},_renderForm:function t(){var e=this,n=window.ss.store,r=n.getState().config.sections.find(function(t){return t.name===m}),o=r.form.TestEditForm.schemaUrl
a.default.render(c.default.createElement(f.Provider,{store:n},c.default.createElement(d.default,{schemaUrl:o,handleSubmit:function t(){return e._handleSubmit.apply(e,arguments)}})),this[0])},_clearForm:function t(){
a.default.unmountComponentAtNode(this[0])},_handleSubmit:function t(e,n,r){return e.preventDefault(),r()}}),t(".TestReactFormBuilder .nav-link").entwine({onclick:function t(e){e.preventDefault()}})})},function(t,e){
t.exports=jQuery},function(t,e){t.exports=React},function(t,e){t.exports=ReactDom},function(t,e){t.exports=ReactRedux},function(t,e){t.exports=FormBuilderLoader}])
