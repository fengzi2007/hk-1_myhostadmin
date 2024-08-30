(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["Login"],{"1b25":function(e,t,o){},"6eca":function(e,t,o){"use strict";var r=o("1b25"),s=o.n(r);s.a},"9ed6":function(e,t,o){"use strict";o.r(t);var r=function(){var e=this,t=e.$createElement,o=e._self._c||t;return o("div",{staticClass:"login"},[o("el-row",{staticStyle:{width:"100%",height:"100%"},attrs:{type:"flex"}},[o("el-col",{staticClass:"hidden-sm-and-down",attrs:{md:14}},[o("el-row",{staticStyle:{width:"100%",height:"100%"},attrs:{type:"flex",justify:"center",align:"middle"}},[o("div",{staticClass:"welcome"},[o("h3",{staticClass:"welcome-title"},[e._v(e._s(e.config.login_page_name))]),o("p",{staticClass:"welcome-desc"},[e._v(e._s(e.config.login_page_desc))])])])],1),o("el-col",{attrs:{sm:24,md:10}},[o("div",{staticClass:"login-right"},[o("div",{staticClass:"box-card card-box"},[o("div",{staticClass:"box-card-head"},[o("h2",{staticClass:"card-head-title"},[e._v(e._s(e.$t("login.title")))]),o("p",{staticClass:"card-head-desc"},[e._v(e._s(e.$t("login.desc")))])]),o("el-form",{ref:"loginForm",staticClass:"loginForm",attrs:{"status-icon":!0,model:e.loginForm,rules:e.loginFormRules,"label-width":"0px"}},[o("el-form-item",{attrs:{prop:"account"}},[o("el-input",{staticClass:"card-box-input",attrs:{type:"text",placeholder:e.acctount_str,clearable:""},model:{value:e.loginForm.account,callback:function(t){e.$set(e.loginForm,"account",t)},expression:"loginForm.account"}})],1),o("el-form-item",{attrs:{prop:"password"}},[o("el-input",{staticClass:"card-box-input",attrs:{type:"password",placeholder:e.$t("login.password"),clearable:"","show-password":""},model:{value:e.loginForm.password,callback:function(t){e.$set(e.loginForm,"password",t)},expression:"loginForm.password"}})],1),e.hasGoogle?o("el-form-item",{attrs:{prop:"code"}},[o("el-input",{staticClass:"card-box-input",attrs:{placeholder:e.$t("plugin.tip14")+"，"+e.$t("plugin.tip15"),clearable:""},model:{value:e.loginForm.code,callback:function(t){e.$set(e.loginForm,"code",t)},expression:"loginForm.code"}})],1):e._e(),o("el-form-item",[o("div",{staticClass:"fboxRow Xbetween"},[o("div",{staticClass:"rember-password"},[o("el-checkbox",{attrs:{label:e.$t("login.rememberPassword")},model:{value:e.typeFlag,callback:function(t){e.typeFlag=t},expression:"typeFlag"}})],1),o("div",[e.version?o("span",{staticClass:"forget-password",on:{click:e.forgetPassword}},[e._v(e._s(e.$t("login.forgetPassword")))]):e._e()])])]),o("el-button",{staticClass:"submit-button",attrs:{type:"primary"},on:{click:e.submitForm}},[e._v(" "+e._s(e.$t("login.title")))])],1)],1)])])],1),o("el-dialog",{staticClass:"googleDialog",attrs:{title:e.$t("plugin.bind_google"),visible:e.isShowDialog,width:"800px","show-close":!1},on:{"update:visible":function(t){e.isShowDialog=t}}},[o("p",{staticStyle:{color:"red"}},[e._v(e._s(e.$t("plugin.tip13")))]),o("el-form",{ref:"googleForm",attrs:{model:e.googleForm,rules:e.googleRules}},[o("el-form-item",{attrs:{label:" ","label-width":"140px"}},[o("img",{staticClass:"img",attrs:{src:e.codeImg,alt:""}})]),e.userInfo.google_auth?o("el-form-item",{attrs:{label:e.$t("plugin.google_secret")+"：","label-width":"140px"}},[e._v(" "+e._s(e.userInfo.google_auth.secret)+" ")]):e._e(),o("el-form-item",{attrs:{label:e.$t("plugin.code")+"：","label-width":"140px",prop:"code"}},[o("el-input",{attrs:{autocomplete:"off",placeholder:e.$t("plugin.tip14")},model:{value:e.googleForm.code,callback:function(t){e.$set(e.googleForm,"code",t)},expression:"googleForm.code"}})],1),o("el-form-item",{attrs:{size:"large",label:" ","label-width":"140px"}},[o("el-button",{attrs:{type:"primary"},on:{click:e.bindGoole}},[e._v(e._s(e.$t("plugin.click_bind"))+" ")])],1)],1)],1)],1)},s=[],a=(o("caad"),o("13d5"),o("d3b7"),o("2532"),o("5cc6"),o("9a8c"),o("a975"),o("735e"),o("c1ac"),o("d139"),o("3a7b"),o("d5d6"),o("82f8"),o("e91f"),o("60bd"),o("5f96"),o("3280"),o("3fcc"),o("ca91"),o("25a1"),o("cd26"),o("3c5d"),o("2954"),o("649e"),o("219c"),o("170b"),o("b39a"),o("72f7"),o("96cf"),o("1da1")),n=o("f61f"),i=o("a1fc"),c={metaInfo:function(){return{title:this.$t("htmlAttrs.title"),titleTemplate:"%s - "+(this.config.login_page_name||"")}},data:function(){return{config:{},version:!1,acctount_str:this.$t("login.customerAccount"),typeFlag:!1,hasGoogle:!1,loginForm:{account:"",password:"",code:""},loginFormRules:{account:[{required:!0,message:this.$t("login.checkAccount"),trigger:"blur"}],password:[{required:!0,message:this.$t("login.checkPassword"),trigger:"blur"}]},userInfo:{},isShowDialog:!1,googleForm:{code:""},codeImg:"",googleRules:{code:[{required:!0,message:this.$t("plugin.tip14"),trigger:"blur"},{pattern:/^[0-9]{6,6}$/,message:this.$t("plugin.tip14")}]}}},methods:{forgetPassword:function(){window.open("https://www.idcsmart.com/wiki_list/1124.html")},getUserInfo:function(){var e=this;return Object(a["a"])(regeneratorRuntime.mark((function t(){var o;return regeneratorRuntime.wrap((function(t){while(1)switch(t.prev=t.next){case 0:return t.prev=0,t.next=3,e.$api.getUserInfo();case 3:o=t.sent,e.userInfo=o,localStorage.setItem("userInfo",JSON.stringify(o)),e.$store.commit("saveUserInfo"),t.next=11;break;case 9:t.prev=9,t.t0=t["catch"](0);case 11:case"end":return t.stop()}}),t,null,[[0,9]])})))()},getCode:function(){var e=this;return Object(a["a"])(regeneratorRuntime.mark((function t(){var o,r;return regeneratorRuntime.wrap((function(t){while(1)switch(t.prev=t.next){case 0:return t.prev=0,t.next=3,i["a"].getCode();case 3:o=t.sent,r="data:img/png;base64,"+window.btoa(new Uint8Array(o).reduce((function(e,t){return e+String.fromCharCode(t)}),"")),e.codeImg=r,t.next=10;break;case 8:t.prev=8,t.t0=t["catch"](0);case 10:case"end":return t.stop()}}),t,null,[[0,8]])})))()},bindGoole:function(){var e=this;this.$refs.googleForm.validate(function(){var t=Object(a["a"])(regeneratorRuntime.mark((function t(o){return regeneratorRuntime.wrap((function(t){while(1)switch(t.prev=t.next){case 0:if(!o){t.next=17;break}return t.prev=1,e.googleLoading=!0,t.next=5,i["a"].bindGoogle(e.googleForm);case 5:e.$message.success(e.$t("common.theBinding")+e.$t("common.success")),e.googleLoading=!1,e.isShowDialog=!1,e.$router.push("/"),t.next=15;break;case 11:t.prev=11,t.t0=t["catch"](1),e.googleLoading=!1,e.$message.error(t.t0.data.msg);case 15:t.next=18;break;case 17:return t.abrupt("return",!1);case 18:case"end":return t.stop()}}),t,null,[[1,11]])})));return function(e){return t.apply(this,arguments)}}())},submitForm:function(){var e=this;this.$refs.loginForm.validate(function(){var t=Object(a["a"])(regeneratorRuntime.mark((function t(o){var r;return regeneratorRuntime.wrap((function(t){while(1)switch(t.prev=t.next){case 0:if(!o){t.next=6;break}e.typeFlag&&(localStorage.setItem("sdyUsername",e.loginForm.account),localStorage.setItem("sdyPassword",e.loginForm.password)),r={username:e.loginForm.account,password:e.loginForm.password,customfield:{google_code:e.loginForm.code}},e.$api.login(r).then(function(){var t=Object(a["a"])(regeneratorRuntime.mark((function t(o){var r;return regeneratorRuntime.wrap((function(t){while(1)switch(t.prev=t.next){case 0:return e.$store.dispatch("getCommonConfig"),localStorage.setItem("customerToken",o.token),e.$store.commit("saveToken",o.token),t.next=4,e.getUserInfo();case 4:e.$message.success({message:e.$t("login.loginSuccess"),duration:1e3}),r=e.$route.query.redirect||"/",e.$router.push(r);case 7:case"end":return t.stop()}}),t)})));return function(e){return t.apply(this,arguments)}}()).catch((function(t){405===t.status?(localStorage.setItem("customerToken",t.data.token),e.$store.commit("saveToken",t.data.token),e.$store.dispatch("getCommonConfig"),e.getUserInfo(),e.$message.success({message:e.$t("login.loginSuccess"),duration:1e3}),e.$router.push("/system-upgrade")):(localStorage.clear(),e.$message.error(t.data.error))})),t.next=7;break;case 6:return t.abrupt("return",!1);case 7:case"end":return t.stop()}}),t)})));return function(e){return t.apply(this,arguments)}}())},keydownEnter:function(e){"Enter"===e.key&&this.submitForm()}},created:function(){var e=this;return Object(a["a"])(regeneratorRuntime.mark((function t(){var o,r,s;return regeneratorRuntime.wrap((function(t){while(1)switch(t.prev=t.next){case 0:return o=localStorage.getItem("sdyUsername"),r=localStorage.getItem("sdyPassword"),o&&r&&(e.loginForm.account=o,e.loginForm.password=r,e.typeFlag=!0),document.addEventListener("keydown",e.keydownEnter),t.next=6,n["a"].getCommonConfig();case 6:s=t.sent,e.config=s.config,e.hasGoogle=s.plugin.includes("GoogleAuth"),localStorage.setItem("commonPlugin",s.plugin),e.getUserInfo();case 11:case"end":return t.stop()}}),t)})))()},destroyed:function(){document.removeEventListener("keydown",this.keydownEnter)}},l=c,g=(o("6eca"),o("2877")),u=Object(g["a"])(l,r,s,!1,null,null,null);t["default"]=u.exports}}]);