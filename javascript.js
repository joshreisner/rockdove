function url_delete() {
	if (confirm("Are you sure you want to delete?")) url_query_set('action','delete');
}

function url_delete() {
	if (confirm("Are you sure you want to delete?")) url_query_set('action','delete');
}

function discard(target) {
	if (confirm("Leave without saving?")) location.href = target;
}

function draw_marker(latitude, longitude, name, description, color) {
    var icon = new GIcon(); 
    icon.image = '/images/markers/' + color + '.png';
    icon.shadow = '/images/markers/shadow.png';
    icon.iconSize = new GSize(12, 20);
    icon.shadowSize = new GSize(22, 20);
    icon.iconAnchor = new GPoint(6, 20);
    icon.infoWindowAnchor = new GPoint(5, 1);

   	var html = "<div class='map_info'><div class='map_title'>" + name + "</div><div class='map_description'>" + description + "</div></div>";

    return map_marker(latitude, longitude, html, icon);
}

function validate_ally(form) {
	var errors = new Array();
	if (!form.name.value.length) errors[errors.length] = "the name field is empty";
	if (!form.url.value.length) errors[errors.length] = "the url field is empty";
	if (!form.description.value.length) errors[errors.length] = "the description field is empty";
	return form_errors(errors);
}

function validate_category(form) {
	var errors = new Array();
	if (!form.name.value.length) errors[errors.length] = "the name field is empty";
	return form_errors(errors);
}

function validate_contact(form) {
	var errors = new Array();
	if (!form.name.value.length) errors[errors.length] = "the name field is empty";
	if (!form.email.value.length) errors[errors.length] = "the email field is empty";
	if (!form.message.value.length) errors[errors.length] = "the message field is empty";
	return form_errors(errors);
}

function validate_event(form) {
	var errors = new Array();
	if (!form.name.value.length) errors[errors.length] = "the name field is empty";
	if (!form.description.value.length) errors[errors.length] = "the description field is empty";
	return form_errors(errors);
}

function validate_login(form) {
	var errors = new Array();
	if (!form.email_address.value.length) errors[errors.length] = "the email field is empty";
	if (!form.password.value.length) errors[errors.length] = "the password field is empty";
	return form_errors(errors);
}

function validate_password(form) {
	var errors = new Array();
	if (!form.email_address.value.length) errors[errors.length] = "the email field is empty";
	return form_errors(errors);
}

function validate_provider(form) {
	var errors = new Array();
	if (text_is_empty(form.name)) errors[errors.length] = "the name field is empty";
	if (radio_is_not_selected(form.tier_id)) errors[errors.length] = "tier must be selected";
	if (text_is_empty(form.service)) errors[errors.length] = "the title field is empty";
	if (text_is_empty(form.description)) errors[errors.length] = "the description field is empty";
	//need something here to insist on validation if you're not an admin
	if (form.tier_id[0].checked) { //organization
		if (text_is_empty(form.address_1)) errors[errors.length] = "the address 1 field is empty";
		if (text_is_empty(form.zip)) errors[errors.length] = "the zip field is empty";
	} else {
		if (text_is_empty(form.email)) errors[errors.length] = "the email field is empty";
	}
	return form_errors(errors);
}

function validate_provider_contact(form) {
	var errors = new Array();
	if (text_is_empty(form.name)) errors[errors.length] = "the name field is empty";
	if (text_is_empty(form.email)) errors[errors.length] = "the email field is empty";
	//if (text_is_empty(form.service)) errors[errors.length] = "the service field is empty";
	if (text_is_empty(form.description)) errors[errors.length] = "the description field is empty";
	return form_errors(errors);
}

function validate_service(form) {
	var errors = new Array();
	if (!form.name.value.length) errors[errors.length] = "the name field is empty";
	return form_errors(errors);
}

function text_is_empty(text) {
	return !text.value.length;
}

function radio_is_not_selected(radio) {
	var oneFound = false;
	for (var i = 0; i < radio.length; i++) {
		if (radio[i].checked) oneFound=true;
	}
	return !oneFound;
}


// Dynamic Drive Code Below http://www.dynamicdrive.com/ THANKS!

var persisteduls = new Object();
var ddtreemenu = new Object();

ddtreemenu.createTree = function(treeid, enablepersist, persistdays) {
	var ultags = document.getElementById(treeid).getElementsByTagName("ul");
	if (typeof persisteduls[treeid]=="undefined")
	persisteduls[treeid]=(enablepersist==true && ddtreemenu.getCookie(treeid)!="")? ddtreemenu.getCookie(treeid).split(",") : ""
	for (var i=0; i<ultags.length; i++)
	ddtreemenu.buildSubTree(treeid, ultags[i], i)
	if (enablepersist==true){ //if enable persist feature
	var durationdays=(typeof persistdays=="undefined")? 1 : parseInt(persistdays)
	ddtreemenu.dotask(window, function(){ddtreemenu.rememberstate(treeid, durationdays)}, "unload") //save opened UL indexes on body unload
	}
}

ddtreemenu.buildSubTree=function(treeid, ulelement, index){
ulelement.parentNode.className="submenu"
if (typeof persisteduls[treeid]=="object"){ //if cookie exists (persisteduls[treeid] is an array versus "" string)
if (ddtreemenu.searcharray(persisteduls[treeid], index)){
ulelement.setAttribute("rel", "open")
ulelement.style.display="block"
ulelement.parentNode.style.backgroundImage="url("+ddtreemenu.openfolder+")"
}
else
ulelement.setAttribute("rel", "closed")
} //end cookie persist code
else if (ulelement.getAttribute("rel")==null || ulelement.getAttribute("rel")==false) //if no cookie and UL has NO rel attribute explicted added by user
ulelement.setAttribute("rel", "closed")
else if (ulelement.getAttribute("rel")=="open") //else if no cookie and this UL has an explicit rel value of "open"
ddtreemenu.expandSubTree(treeid, ulelement) //expand this UL plus all parent ULs (so the most inner UL is revealed!)
ulelement.parentNode.onclick=function(e){
var submenu=this.getElementsByTagName("ul")[0]
if (submenu.getAttribute("rel")=="closed"){
submenu.style.display="block"
submenu.setAttribute("rel", "open")
//ulelement.parentNode.style.backgroundImage="url("+ddtreemenu.openfolder+")"
}
else if (submenu.getAttribute("rel")=="open"){
submenu.style.display="none"
submenu.setAttribute("rel", "closed")
//ulelement.parentNode.style.backgroundImage="url("+ddtreemenu.closefolder+")"
}
ddtreemenu.preventpropagate(e)
}
ulelement.onclick=function(e){
ddtreemenu.preventpropagate(e)
}
}

ddtreemenu.expandSubTree=function(treeid, ulelement){ //expand a UL element and any of its parent ULs
var rootnode=document.getElementById(treeid)
var currentnode=ulelement
currentnode.style.display="block"
currentnode.parentNode.style.backgroundImage="url("+ddtreemenu.openfolder+")"
while (currentnode!=rootnode){
if (currentnode.tagName=="UL"){ //if parent node is a UL, expand it too
currentnode.style.display="block"
currentnode.setAttribute("rel", "open") //indicate it's open
currentnode.parentNode.style.backgroundImage="url("+ddtreemenu.openfolder+")"
}
currentnode=currentnode.parentNode
}
}

ddtreemenu.flatten=function(treeid, action){ //expand or contract all UL elements
var ultags=document.getElementById(treeid).getElementsByTagName("ul")
for (var i=0; i<ultags.length; i++){
ultags[i].style.display=(action=="expand")? "block" : "none"
var relvalue=(action=="expand")? "open" : "closed"
ultags[i].setAttribute("rel", relvalue)
//ultags[i].parentNode.style.backgroundImage=(action=="expand")? "url("+ddtreemenu.openfolder+")" : "url("+ddtreemenu.closefolder+")"
}
}

ddtreemenu.rememberstate=function(treeid, durationdays){ //store index of opened ULs relative to other ULs in Tree into cookie
var ultags=document.getElementById(treeid).getElementsByTagName("ul")
var openuls=new Array()
for (var i=0; i<ultags.length; i++){
if (ultags[i].getAttribute("rel")=="open")
openuls[openuls.length]=i //save the index of the opened UL (relative to the entire list of ULs) as an array element
}
if (openuls.length==0) //if there are no opened ULs to save/persist
openuls[0]="none open" //set array value to string to simply indicate all ULs should persist with state being closed
ddtreemenu.setCookie(treeid, openuls.join(","), durationdays) //populate cookie with value treeid=1,2,3 etc (where 1,2... are the indexes of the opened ULs)
}

////A few utility functions below//////////////////////

ddtreemenu.getCookie=function(Name){ //get cookie value
var re=new RegExp(Name+"=[^;]+", "i"); //construct RE to search for target name/value pair
if (document.cookie.match(re)) //if cookie found
return document.cookie.match(re)[0].split("=")[1] //return its value
return ""
}

ddtreemenu.setCookie=function(name, value, days){ //set cookei value
var expireDate = new Date()
//set "expstring" to either future or past date, to set or delete cookie, respectively
var expstring=expireDate.setDate(expireDate.getDate()+parseInt(days))
document.cookie = name+"="+value+"; expires="+expireDate.toGMTString()+"; path=/";
}

ddtreemenu.searcharray=function(thearray, value){ //searches an array for the entered value. If found, delete value from array
var isfound=false
for (var i=0; i<thearray.length; i++){
if (thearray[i]==value){
isfound=true
thearray.shift() //delete this element from array for efficiency sake
break
}
}
return isfound
}

ddtreemenu.preventpropagate=function(e){ //prevent action from bubbling upwards
if (typeof e!="undefined")
e.stopPropagation()
else
event.cancelBubble=true
}

ddtreemenu.dotask=function(target, functionref, tasktype){ //assign a function to execute to an event handler (ie: onunload)
var tasktype=(window.addEventListener)? tasktype : "on"+tasktype
if (target.addEventListener)
target.addEventListener(tasktype, functionref, false)
else if (target.attachEvent)
target.attachEvent(tasktype, functionref)
}