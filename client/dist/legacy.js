!function(e){function t(r){if(n[r])return n[r].exports
var o=n[r]={exports:{},id:r,loaded:!1}
return e[r].call(o.exports,o,o.exports,t),o.loaded=!0,o.exports}var n={}
return t.m=e,t.c=n,t.p="",t(0)}([function(e,t,n){"use strict"
n(1)},function(e,t,n){"use strict"
function r(e){return e&&e.__esModule?e:{default:e}}var o=n(2),i=r(o),u=n(3),c=r(u),s=n(4),a=r(s),f=n(5),l=n(6),d=r(l),m=n(7),p="TestReactFormBuilder",h=(0,m.provideInjector)(d.default)
i.default.entwine("ss",function(e){e(".TestReactFormBuilder").entwine({onmatch:function e(){var t=this
setTimeout(function(){return t._renderForm()},100),this[0].style.setProperty("overflow-y","scroll","important")},onunmatch:function e(){this._clearForm(),this.css("overflow-y",!1)},open:function e(){this._renderForm()

},close:function e(){this._clearForm()},_renderForm:function e(){var t=this,n=window.ss.store,r=n.getState().config.sections.find(function(e){return e.name===p}),o=r.form.TestEditForm.schemaUrl
a.default.render(c.default.createElement(f.Provider,{store:n},c.default.createElement(h,{identifier:"TestReactForm",schemaUrl:o,handleSubmit:function e(){return t._handleSubmit.apply(t,arguments)}})),this[0])

},_clearForm:function e(){a.default.unmountComponentAtNode(this[0])},_handleSubmit:function e(t,n,r){return t.preventDefault(),r()}}),e(".TestReactFormBuilder .nav-link").entwine({onclick:function e(t){
t.preventDefault()}})})},function(e,t){e.exports=jQuery},function(e,t){e.exports=React},function(e,t){e.exports=ReactDom},function(e,t){e.exports=ReactRedux},function(e,t){e.exports=FormBuilderLoader},function(e,t){
e.exports=Injector}])
